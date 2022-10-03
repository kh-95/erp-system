<?php

namespace App\Modules\Governance\Http\Repositories\Notification;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Governance\Entities\Notification;
use App\Modules\Governance\Http\Requests\NotificationRequest;
use App\Modules\Governance\Http\Requests\NotificationResponseRequest;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Repositories\CommonRepository;
use Arr;

class NotificationRepository extends CommonRepository implements NotificationRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    public function model()
    {
        return Notification::class;
    }

    public function filterColumns()
    {
        return [
            'title',
            'created_at',
            'status',
            'management_id',
            'employee_id',
        ];
    }


    public function sortColumns()
    {

        return [
            'title',
            'created_at',
            'status',
            'body',
            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. Notification::getTableName().'.'.'employee_id.first_name'),
            $this->sortUsingRelationship('management-name',ManagementTranslation::getTableName().'.'. Notification::getTableName().'.'.'management_id.name'),
        ];
    }

    public function updateNotification(NotificationRequest $request, Notification $notification)
    {
        $data = $request->validated();
        $notification->update(Arr::except($data, ['attachments', 'file_type']));
        $this->storeRelationships($request, $notification);

        return $notification;
    }


    public function show($id)
    {
        $notification =$this->model()::findOrFail($id)->load('attachments');
        $notification->status = 'viewed';
        $notification->save();
        return $notification ;
    }

    public function store(NotificationRequest $request)
    {
        $data = $request->all();
        $notification = $this->model()::create(Arr::except($data, ['attachments', 'file_type']));
        $this->storeRelationships($request, $notification);

        return $notification;
    }

    public function storeResponse(NotificationResponseRequest $request, $id)
    {
        $notification = $this->model()::findOrFail($id);
        $data = $request->validated();
        $notification->fill($data)->save();
        return $notification;
    }

    private function storeRelationships($request, Notification $notification)
    {
        if ($request->isMethod('PUT')) {
            $notification->attachments()->delete();
            $notification->attachments->map(function ($item, $key) {
                $this->deleteImage($item, 'governance_notifications');
            });
        }

        if ($request->has('attachments') && $request->attachments != null) {
            $attachments = collect($request->attachments)->map(function ($item, $key) {
                $data['media'] = $this->storeImage($item, 'governance_notifications');
                $data['type'] = $key;
                return $data;
            })->values()->toArray();

            $notification->attachments()->createMany($attachments);
        }
    }
}
