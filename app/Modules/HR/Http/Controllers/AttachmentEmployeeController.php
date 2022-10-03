<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Http\Controllers\Controller;
use App\Modules\HR\Http\Repositories\Employee\AttachmentEmployeeRepositoryInterface;
use App\Modules\HR\Http\Requests\Employee\AttachmentRequest;

class AttachmentEmployeeController extends Controller
{
    use ApiResponseTrait, ImageTrait;

    private AttachmentEmployeeRepositoryInterface $attachmentEmployeeRepository;

    public function __construct(AttachmentEmployeeRepositoryInterface $attachmentEmployeeRepository)
    {
        $this->attachmentEmployeeRepository = $attachmentEmployeeRepository;
    }

    public function store(AttachmentRequest $request, $id)
    {
        return $this->attachmentEmployeeRepository->store($request, $id);
    }

    public function update(AttachmentRequest $request, $id)
    {
        return $this->attachmentEmployeeRepository->edit($request, $id);
    }

    public function destroy($id)
    {
        return $this->attachmentEmployeeRepository->destroy($id);
    }
}
