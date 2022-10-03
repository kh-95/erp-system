<?php

namespace App\Modules\Reception\Http\Repositories\ReceptionReport;

use App\Modules\Reception\Entities\Report;
use App\Repositories\CommonRepository;
use App\Modules\Reception\Http\Repositories\ReceptionReport\ReceptionReportRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ReceptionReportRepository extends CommonRepository implements ReceptionReportRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'title',
            'management_id',
            'description',
            'status',
            'date',
        ];
    }
    public function store(array $attr)
    {
        try {

            $attr['date'] = Carbon::parse($attr['date'] . $attr['time'] . $attr['time_type'])->format('Y-m-d H:i');
            Arr::forget($attr, ['time', 'time_type']);
            return  $this->create($attr);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }
    public function updateReceptionReport(array $attr, $id)
    {
        try {

            $attr['date'] = Carbon::parse($attr['date'] . $attr['time'] . $attr['time_type'])->format('Y-m-d H:i');
            Arr::forget($attr, ['time', 'time_type']);
            return  $this->update($attr, $id);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function updateStatus($id, $status)
    {
        $record = $this->find($id);
        $record->update([
            'status' => $status
        ]);
        return $this->successResponse(['message' => __('reception::messages.receptionReport.toggle_successfuly')]);
    }
    public function destroy($id)
    {
        $this->delete($id);
        return $this->successResponse(['message' => __('reception::messages.receptionReport.deleted_successfuly')]);
    }

    public function restore($id)
    {
        $record = $this->withTrashed()->find($id);
        $record->update([
            'deleted_at' => NULL
        ]);
        return $this->successResponse(['message' => __('reception::messages.receptionReport.restored_successfuly')]);
    }

    public function model()
    {
        return Report::class;
    }
}
