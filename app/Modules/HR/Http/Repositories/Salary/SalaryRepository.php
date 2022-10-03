<?php

namespace App\Modules\HR\Http\Repositories\Salary;

use App\Modules\HR\Entities\Salary;
use App\Repositories\CommonRepository;
use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Entities\SalaryApprove;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\DeferredDeduct;
use App\Modules\HR\Http\Requests\Salary\SalaryRequest;
use App\Modules\HR\Transformers\Salary\SalaryDetailsResource;
use App\Modules\HR\Http\Repositories\Salary\SalaryRepositoryInterface;

class SalaryRepository extends CommonRepository implements SalaryRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'employee.job.management.id',
            'employee.jobInformation.employee_number',
            'employee_id',
            'employee.identification_number',
            'month',
        ];
    }
    public function model()
    {
        return Salary::class;
    }

    public function show($id)
    {
        $salaryDetails = $this->with('employee.allowances')->findOrFail($id);
        $salaryApproveMonth = \Carbon\Carbon::parse($salaryDetails->month)->month;

        $isSigned = SalaryApprove::whereYear('month',$salaryDetails->month)
        ->whereMonth('month',$salaryApproveMonth)
        ->first()?->value('is_signed');

        $currentMonthDeducts = DeductBonus::whereYear('created_at',$salaryDetails->month)
        ->whereMonth('created_at',$salaryApproveMonth)
        ->where('employee_id', $salaryDetails->employee_id)
        ->where('type', 'deduct')
        ->whereNull('applicable_at')->sum('amount');

        $deferredDeducts = DeferredDeduct::whereDate('month','<',$salaryDetails->month)
        ->where('employee_id', $salaryDetails->employee_id)->sum('deferred_amount');

        $deferredData = DeferredDeduct::whereYear('month',$salaryDetails->month)
        ->whereMonth('month',$salaryApproveMonth)
        ->where('employee_id', $salaryDetails->employee_id)->select('deduction_percentage', 'net_salary')->first();

        $salaryDetails->is_signed = $isSigned;
        $salaryDetails->current_month_deducts = $currentMonthDeducts ;
        $salaryDetails->deferred_deducts = $deferredDeducts;
        $salaryDetails->deduction_percentage = $deferredData->deduction_percentage ?? 0;
        $salaryDetails->net_salary = $deferredData->net_salary ??$salaryDetails->net_salary  ;

        return $this->successResponse(new SalaryDetailsResource($salaryDetails));
    }

    public function updatedeductPercentage(SalaryRequest $request, $id)
    {

        $salaryDetails = $this->findOrFail($id);
        $salaryApproveMonth = \Carbon\Carbon::parse($salaryDetails->month)->month;

        $currentMonthDeducts = DeductBonus::whereYear('created_at', $salaryDetails->month)
            ->whereMonth('created_at', $salaryApproveMonth)
            ->where('employee_id', $salaryDetails->employee_id)
            ->where('type', 'deduct')
            ->whereNull('applicable_at')->sum('amount');

        $deferredDeducts = DeferredDeduct::whereDate('month', '<', $salaryDetails->month)
            ->where('employee_id', $salaryDetails->employee_id)->sum('deferred_amount');

        $totalDeducts = $currentMonthDeducts + $deferredDeducts;
        $netSalary = $salaryDetails->gross_salary - ($salaryDetails->gross_salary * $request->deduction_percentage);
        $deducted_amount = $salaryDetails->gross_salary - $netSalary;
        $deferred_amount = $totalDeducts -  $deducted_amount;

        $deferredDeduct = DeferredDeduct::updateOrCreate(
            ['employee_id' => $salaryDetails->employee_id, 'month' => $salaryDetails->month],
            [
                'deduction_percentage' => $request->deduction_percentage,
                'net_salary' => $netSalary,
                'deducted_amount' => $deducted_amount,
                'deferred_amount' => $deferred_amount,
            ]
        );

        $salaryDetails->update(['net_salary' => $netSalary]);

        $salaryDetails->deduction_percentage = $deferredDeduct->deduction_percentage;
        return $this->apiResource(SalaryDetailsResource::make($salaryDetails), true, __('Common::message.success_update'));
    }



}
