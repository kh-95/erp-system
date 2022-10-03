<?php

namespace App\Modules\Legal\Http\Repositories\CompanyCase;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Legal\Entities\CompanyCase;
use App\Modules\Legal\Entities\CompanyCasePayment;
use App\Modules\Legal\Entities\CompanyCaseSession;
use App\Modules\Legal\Http\Requests\CompanyCaseRequest;
use App\Repositories\AttachesRepository;
use App\Repositories\CommonRepository;
use Illuminate\Support\Arr;

class CompanyCaseRepository extends CommonRepository implements CompanyCaseRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function model()
    {
        return CompanyCase::class;
    }

    public function filterColumns()
    {
        return [
            'case_number',
            'request.request_number',
            'area.name',
            'status',
            'vendor_name',
            'vendor_phone',
            'contract_number',
            'amount',
            'execution_status',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            $this->createdAtBetween('case_date1'),
            $this->createdAtBetween('case_date2'),
            $this->createdAtBetween('session.session_date1'),
            $this->createdAtBetween('session.session_date2'),
        ];
    }


    public function sortColumns()
    {
        return [
            'case_number',
            'area.name',
            'created_at',
            'status',
            'contract_number',
            'employee.name',
            'amount',
            'execution_status',
            'case_date1',
            'case_date2',
            'session.session_date1',
            'session.session_date2',
        ];
    }


    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function store(CompanyCaseRequest $request)
    {
        $data = $request->validated();
        $case = $this->model()::make()->fill(Arr::except($data, ['sessions', 'payments', 'attachments']));
        $case->save();
        $case?->sessions()->createMany($data['sessions']);
        $case?->payments()->createMany($data['payments']);
        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('company_case_attachments', $request, $case);
            $attaches->addAttaches();
        }
        $case->load('sessions', 'payments', 'attachments');
        return $case;
    }

    public function updateCompanyCase(CompanyCaseRequest $request, $id)
    {
        $case = CompanyCase::findOrFail($id);
        $data = $request->validated();
//        $data = $request->all();
        $case->fill(Arr::except($data, ['sessions', 'payments', 'attachments']));
        $case->save();
        $oldSessionsIds = $case->sessions()->pluck('id');
        $oldPaymentsIds = $case->payments()->pluck('id');
        $newSessionsIds = array_column($data['sessions'] ?? [], 'id');
        $newPaymentsIds = array_column($data['payments'] ?? [], 'id');

        foreach ($oldSessionsIds as $id) {
            if (!in_array($id, $newSessionsIds)) {
                CompanyCaseSession::find($id)->delete();
            }
        }
        foreach ($oldPaymentsIds as $id) {
            if (!in_array($id, $newPaymentsIds)) {
                CompanyCasePayment::find($id)->delete();
            }
        }

        foreach ($data['sessions'] ?? [] as $index => $session) {
            if (CompanyCaseSession::find(@$session['id'])) {
                CompanyCaseSession::find(@$session['id'])->update(Arr::except($data['sessions'][$index], ['id']));
            } else {
                $case->sessions()->create(Arr::except($data['sessions'][$index], ['id']));
            }
        }
        foreach ($data['payments'] ?? [] as $index => $payment) {
            if (CompanyCasePayment::find(@$payment['id'])) {
                CompanyCasePayment::find(@$payment['id'])->update(Arr::except($data['payments'][$index], ['id']));
            } else {
                $case->payments()->create(Arr::except($data['payments'][$index], ['id']));
            }
        }
        if (array_key_exists('attachments', $request->validated())) {
            $this->deleteCompanyCaseImage($case->attachments);
            $attaches = new AttachesRepository('company_case_attachments', $request, $case);
            $attaches->addAttaches();
        }
        $case->load('sessions', 'payments', 'attachments');
        return $case;
    }

    private function deleteCompanyCaseImage($company_case_attaches)
    {
        $company_case_attaches->map(function ($item) {
            $this->deleteImage($item->file, 'company_case_attachments');
            $item->delete();
        });
    }
}
