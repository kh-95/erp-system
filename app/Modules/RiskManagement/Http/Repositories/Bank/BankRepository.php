<?php

namespace App\Modules\RiskManagement\Http\Repositories\Bank;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Repositories\CommonRepository;
use App\Modules\RiskManagement\Http\Requests\BankRequest;
use App\Modules\RiskManagement\Entities\Bank;
use Illuminate\Database\Eloquent\Collection;



class BankRepository extends CommonRepository implements BankRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function model()
    {
        return Bank::class;
    }

    public function filterColumns()
    {
        return [
            $this->translated('name'),
            'created_at',
            'is_active',

        ];
    }


    public function sortColumns()
    {
        return [
            'name',
            'created_at',
            'is_active',
        ];
    }


    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function store(BankRequest $request)
    {
        return $this->create($request->validated());
    }

    public function updateBank(BankRequest $request, $id)
    {
        $bank = $this->find($id);
        $bank->update($request->validated());
        return $bank;

    }


    public function listBanks()
    {
        return $this->ListsTranslations('name')
            ->addSelect('rm_banks.id')
            ->get();
    }
}
