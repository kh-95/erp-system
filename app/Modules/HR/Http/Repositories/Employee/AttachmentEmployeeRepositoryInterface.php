<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Modules\HR\Http\Requests\Employee\AttachmentRequest;
use App\Repositories\CommonRepositoryInterface;

interface AttachmentEmployeeRepositoryInterface extends CommonRepositoryInterface
{
    public function store(AttachmentRequest $request, $id);
    public function edit(AttachmentRequest $request, $id);
    public function destroy($id);
}
