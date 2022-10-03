<?php

namespace App\Modules\Governance\Http\Repositories\Regulation;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;

use App\Foundation\Traits\FileTrait;
use App\Modules\Governance\Entities\Regulation;
use App\Modules\Governance\Entities\RegulationAttachment;
use App\Modules\Governance\Http\Requests\RegulationRequest;
use App\Modules\HR\Entities\Employee;
use App\Repositories\CommonRepository;
use Carbon\Carbon;

class RegulationRepository extends CommonRepository implements RegulationRepositoryInterface
{
    use ApiResponseTrait, FileTrait;

    public function filterColumns()
    {
        return [
            'from_year',
            'to_year',
            'is_active',
            $this->translated('title'),
        ];
    }

    public function sortColumns()
    {
        return [
            'from_year',
             'to_year',
              'is_active',
               'created_at',
               $this->sortingTranslated('title', 'title'),
               $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. Regulation::getTableName().'.'.'added_by_id.first_name'),
        ];
    }

    public function model()
    {
        return Regulation::class;
    }

    private function fileStore($files, $regulation)
    {
        foreach ($files['files'] as $file) {
            $attachment = explode('/', $file->getMimeType());
            $file_name = $this->storeFile($file, $attachment[0], Regulation::REGULATION);
            RegulationAttachment::create(['media' => $file_name, 'regulation_id' => $regulation->id, 'type' => $this->baseByType($attachment[0])]);
        }
    }


    public function store(RegulationRequest $request)
    {
        $regulation = $request->safe()->except('files');
        $files = $request->safe()->only('files');

        $regulation = $this->create($regulation + ['added_by_id' => auth()->id()]);

        $this->fileStore($files, $regulation);

        return $regulation;
    }


    public function show($id)
    {
        return $this->findOrFail($id)->load('addedBy', 'regulationAttachments');
    }

    public function edit($id)
    {
        return $this->findOrFail($id)->load('addedBy', 'regulationAttachments');
    }

    public function updateRegulation(RegulationRequest $request, $id)
    {
        $all_regulation = $request->safe()->except('files');
        $files = $request->safe()->only('files');
        $regulation = $this->find($id);

        if (!empty($files)) {
            $this->fileStore($files, $regulation);
        }

        $regulation->update($all_regulation);
        return $regulation;
    }

    public function destroy($id)
    {
        $regulation = $this->find($id);
        $files = $regulation->regulationAttachments;
        foreach ($files as $file) {
            $this->deleteFile($file->media, $file->type, Regulation::REGULATION);
        }
        return $regulation->delete($id);
        //       return $this->successResponse(['message' => __('hr::messages.management.deleted_successfuly')]);
    }

    public function deleteAttachmentRegulation($id)
    {
        $file = RegulationAttachment::find($id);
        $this->deleteFile($file->media, $file->type, Regulation::REGULATION);
        $file->delete();
    }
}
