<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\Entities\Attachment;
use App\Modules\HR\Http\Requests\Employee\AttachmentRequest;
use App\Repositories\CommonRepository;

class AttachmentEmployeeRepository extends CommonRepository implements AttachmentEmployeeRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function model()
    {
        return Attachment::class;
    }

    public function store(AttachmentRequest $request, $id)
    {
        try
        {
            $data = $request->except('file');
            $data['file'] = $this->storeImage($request->file, 'attachments');
            $data['employee_id'] = $id;
            $this->create($data);
            return $this->successResponse(true);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function edit(AttachmentRequest $request, $id)
    {
        try
        {
            $attachment = $this->find($id);
            $data = $request->except('file');
            if ($request->file) {
                $data['file'] = $this->updateImage($request->file, $attachment->image, 'attachments');
            }
            $attachment->update($data);
            return $this->successResponse(true);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try
        {
            $attachment = $this->find($id);
            $this->deleteImage($attachment->image, 'attachments');
            $attachment->delete();
            return $this->successResponse(true);
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
}
