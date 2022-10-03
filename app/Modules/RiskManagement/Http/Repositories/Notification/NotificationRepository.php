<?php

namespace App\Modules\RiskManagement\Http\Repositories\Notification;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Entities\NotificationTerm;
use App\Modules\RiskManagement\Http\Repositories\Notification\NotificationInterface;
use App\Modules\RiskManagement\Http\Requests\NotificationRequest;
use App\Repositories\CommonRepository;
use Illuminate\Support\Arr;

class NotificationRepository extends CommonRepository implements NotificationInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return Notification::class;
    }

    public function filterColumns()
    {
        return [
            'title',
            'is_active',
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'title',
            'body',
            'is_active',
            'created_at',
        ];
    }

    public function show($id)
    {
        return  $this->model()::with(['terms' => fn ($q) => $q->orderBy('rm_notification_terms.order')])->findOrFail($id);
    }

    public function store(NotificationRequest $request)
    {
        $data = $request->validated();
        $notification = $this->model()::make()->fill(Arr::except($data, ['terms']));
        $notification->save();
        $notification->terms()->createMany($data['terms']);
        $notification->load('terms');

        return $notification;
    }

    public function updateNotification(NotificationRequest $request, Notification $notification)
    {
        $data = $request->validated();
        $notification->fill(Arr::except($data, ['terms']))->save();
        $oldTermsIds = $notification->terms()->pluck('id');
        $newTermsIds = array_column($data['terms'] ?? [], 'id');

        foreach ($oldTermsIds as $id) {
            if (!in_array($id, $newTermsIds)) {
                NotificationTerm::find($id)->delete();
            }
        }

        foreach ($data['terms'] ?? [] as $index => $term) {
            if (NotificationTerm::find(@$term['id'])) {
                NotificationTerm::find(@$term['id'])->update(Arr::except($data['terms'][$index], ['id']));
            } else {
                $notification->terms()->create(Arr::except($data['terms'][$index], ['id']));
            }
        }

        $notification->load('terms');

        return $notification;
    }
}
