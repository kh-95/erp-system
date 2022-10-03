<?php

namespace App\Modules\Legal\Http\Repositories\JudicialDepartment;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;
use App\Modules\Legal\Http\Requests\JudicialDepartmentRequest;
use App\Repositories\CommonRepository;

class JudicialDepartmentRepository extends CommonRepository implements JudicialDepartmentRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function model()
    {
        return JudicialDepartment::class;
    }

    public function filterColumns()
    {
        return [
            'translations.name',
            'translations.description',
            'area',
            'court',
        ];
    }


    public function sortColumns()
    {
        return [
            'translations.name',
            'translations.description',
            'area',
            'court',
            'email',
        ];
    }


    public function store(JudicialDepartmentRequest $request)
    {
        $data = $request->validated();
        $judicialDepartment = $this->model()::create($data);

        return $judicialDepartment;
    }


    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function updateJudicialDepartment(JudicialDepartmentRequest $request, JudicialDepartment $judicialDepartment)
    {
        $data = $request->validated();
        $judicialDepartment->update($data);

        return $judicialDepartment;
    }


    public function deleteJudicialDepartment(JudicialDepartment $judicialDepartment)
    {
        $judicialDepartment->delete();
    }
}
