<?php

namespace App\Modules\RiskManagement\Http\Repositories\NotificationVendor;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Http\Requests\TakenActionRequest;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class NotificationVendorRepository extends CommonRepository implements NotificationVendorRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return NotificationVendor::class;
    }

    public function filterColumns()
    {
        return [
            'title',
            'taken_action',
            'vendor.type',
            'vendor.subscription',
            'vendor.name',
            AllowedFilter::scope('createdFrom'),
            AllowedFilter::scope('createdTo'),
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'created_at',
            $this->sortUsingRelationship('notify_title', 'rm_notifications.rm_notification_vendors.notification_id.title'),
            $this->sortUsingRelationship('notify_body', 'rm_notifications.rm_notification_vendors.notification_id.body'),
            $this->sortUsingRelationship('vendor_name', 'rm_vendors.rm_notification_vendors.vendor_id.name'),
            $this->sortUsingRelationship('vendor_subscription', 'rm_vendors.rm_notification_vendors.vendor_id.subscription'),
            'taken_action'
        ];
    }

    public function show($id)
    {
        return  $this->model()::with(['vendor', 'notification'])->findOrFail($id);
    }

    public function index(Request $request)
    {
    }

    public function takeAction(NotificationVendor $notificationVendor, TakenActionRequest $request)
    {
    }
}
