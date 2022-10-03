<?php

namespace App\Modules\HR\Http\Repositories\PermissionRequest;

use App\Modules\HR\Entities\PermissionRequest;
use App\Modules\HR\Http\Requests\PermissionRequest\PermissionRequestRequest;
use App\Modules\HR\Http\Requests\PermissionRequest\updatePermissionRequestRequest;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\PermissionRequest\updateHrPermissionRequestRequest;
use Illuminate\Http\Request;

interface PermissionRequestRepositoryInterface extends CommonRepositoryInterface
{
    public function store(PermissionRequestRequest $request);
    public function updateStatus(updatePermissionRequestRequest $request, PermissionRequest $permissionRequest);
    public function updateStatusHr(updateHrPermissionRequestRequest $request, PermissionRequest $permissionRequest);
    public function permission_request_managements(Request $request);
}
