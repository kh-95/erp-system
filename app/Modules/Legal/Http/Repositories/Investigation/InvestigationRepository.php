<?php

namespace App\Modules\Legal\Http\Repositories\Investigation;

use App\Foundation\Classes\Helper;
use App\Modules\Legal\Http\Repositories\Investigation\InvestigationRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Legal\Entities\Investigation;
use App\Modules\Legal\Entities\InvestigationQuestions;
use App\Repositories\CommonRepository;
use App\Modules\Legal\Http\Requests\Investigation\UpdateInvestigationRequest;
use App\Modules\Legal\Http\Requests\Investigation\StoreInvestigationRequest;
use Illuminate\Support\Arr;
use App\Repositories\AttachesRepository;



class InvestigationRepository extends CommonRepository implements InvestigationRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'investigation_number',
            'subject',
            'employee_id',
            'management_id',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            'investigation_result',
            'status',

        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            'investigation_number',
            'subject',
            $this->sortUsingRelationship('first_name', 'hr_employees.legal_investigations.employee_id.first_name'),

            'asignedEmployee.first_name',
            'created_at',
            'status',
        ];
    }

    public function model()
    {
        return Investigation::class;
    }


    public function store(StoreInvestigationRequest $request)
    {
        $data = $request->validated();
        $investigation = $this->model()::make()->fill(Arr::except($data, ['attachments'])+['investigation_number' => Helper::generate_unique_code(Investigation::class, 'investigation_number', 10, 'numbers')]);
        $investigation->save();
        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('investigation_attachments', $request, $investigation);
            $attaches->addAttaches();
        }
        $investigation->load('attachments');
        return $investigation;
        }


    public function show($id)
    {
        return $this->findOrFail($id);
    }

    public function edit($id)
    {
        return $this->findOrFail($id);

    }

    public function updateInvestigation(UpdateInvestigationRequest $request, $id)
    {
        $investigation = Investigation::findOrFail($id);
        $data = $request->validated();
        $investigation->fill(Arr::except($data, ['investigation_questions', 'attachments']));
        $investigation->save();
        $oldQuestionsIds = $investigation->investigationQuestions()->pluck('id');
        $newQuestionsIds = array_column($data['investigation_questions'] ?? [], 'id');

        foreach ($oldQuestionsIds as $id) {
            if (!in_array($id, $newQuestionsIds)) {
                InvestigationQuestions::find($id)->delete();
            }
        }

        foreach ($data['investigation_questions'] ?? [] as $index => $investigationQuestions) {
            if (InvestigationQuestions::find(@$investigationQuestions['id'])) {
                InvestigationQuestions::find(@$investigationQuestions['id'])->update(Arr::except($data['investigation_questions'][$index], ['id']));
            } else {
                $investigation->investigationQuestions()->create(Arr::except($data['investigation_questions'][$index], ['id']));
            }
        }

        if (array_key_exists('attachments', $request->validated())) {
            $this->deleteInvestigationImage($investigation->attachments);
            $attaches = new AttachesRepository('investigation_attachments', $request, $investigation);
            $attaches->addAttaches();
        }
        $investigation->load('investigationQuestions', 'attachments');
        return $investigation;

    }

    private function deleteInvestigationImage($investigation_attaches)
    {
        $investigation_attaches->map(function ($item) {
            $this->deleteImage($item->file, 'investigation_attachments');
            $item->delete();
        });
    }




}
