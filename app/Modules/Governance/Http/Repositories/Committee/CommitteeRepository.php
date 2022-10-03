<?php

namespace App\Modules\Governance\Http\Repositories\Committee;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Governance\Entities\Committee;
use App\Modules\Governance\Entities\CommitteeEmployee;
use App\Modules\Governance\Http\Repositories\Committee\CommitteeRepositoryInterface;

use App\Modules\Governance\Http\Requests\CommitteeRequest;
use App\Modules\HR\Entities\Employee;
use App\Repositories\AttachesRepository;
use App\Repositories\CommonRepository;
use Illuminate\Support\Arr;

class CommitteeRepository extends CommonRepository implements CommitteeRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function filterColumns()
    {
        return [
            $this->translated('name'),
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            'is_active',
            'employees.first_name'
        ];
    }

    public function sortColumns()
    {
        return [
             'id',
             $this->sortingTranslated('name', 'name'),
            'creation_date',
            'is_active',
        ];
    }

    public function model()
    {
        return Committee::class;
    }

    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function store(CommitteeRequest $request)
    {
        $data = $request->validated();
        $committee = $this->model()::make()->fill(Arr::except($data, ['employees', 'attachments', 'file_type']));
        $committee->save();
        $ids = [];
        foreach ($data['employees'] ?? [] as $key => $employee) {
            $ids[$employee['id']] = ['is_president' => (bool)$employee['is_president']];
        }
        $committee->employees()->sync($ids);
        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('committee_attachments', $request, $committee);
            $attaches->addAttaches();
        }
        $committee->load('attachments', 'employees');
        return $committee;
    }

   

    public function updateCommittee(CommitteeRequest $request, $id)
    {
        $committee = Committee::findOrFail($id);
        $data = $request->validated();
        $committee->fill(Arr::except($data, ['attachments', 'employees', 'file_type']));
        $committee->save();
        $ids = [];
        foreach ($data['employees'] ?? [] as $key => $employee) {
            $ids[$employee['id']] = ['is_president' => (bool)$employee['is_president']];
        }
        $committee->employees()->sync($ids);
        if (array_key_exists('attachments', $request->validated())) {
            $this->deleteCommitteeImage($committee->attachments);
            $attaches = new AttachesRepository('committee_attachments', $request, $committee);
            $attaches->addAttaches();
        }
        $committee->load('attachments', 'employees');
        return $committee;
    }


    public function destroy($id)
    {
        $committee = $this->findOrFail($id);
        if (!$committee->is_active) {
            $this->delete($id);
            return $this->successResponse(['message' => __('governance::messages.general.successfully_deleted')]);
        }
        return $this->errorResponse(['message' => __('governance::messages.commitee.canot_delete_commitee')]);

     }

    private function deleteCommitteeImage($committee_attaches)
    {
        $committee_attaches->map(function ($item) {
            $this->deleteImage($item->file, 'committee_attachments');
            $item->delete();
        });
    }

}
