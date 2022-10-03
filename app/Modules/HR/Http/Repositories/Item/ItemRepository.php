<?php

namespace App\Modules\HR\Http\Repositories\Item;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use \App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Http\Requests\ItemRequest;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedFilter;

class ItemRepository extends CommonRepository implements ItemRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'translations.name',
            AllowedFilter::scope('score_from'),
            AllowedFilter::scope('score_to'),

        ];
    }

    public function sortColumns()
    {
        return [
            'score',
        ];
    }

    public function model()
    {
        return Item::class;
    }


    public function store(ItemRequest $request)
    {
        return $this->create($request->validated() + ['added_by_id' => auth()->id()]);
    }


    public function show($id)
    {
        return $this->findOrFail($id);
    }

    public function edit($id)
    {
        return $this->findOrFail($id);
    }

    public function updateInterviewItem(ItemRequest $request, $id)
    {
        $row = $this->find($id);
        $row->update($request->validated());
        return $row;
    }

    public function destroy($id){
       return $this->delete($id);
      //  return $this->successResponse(['message' => __('hr::messages.management.deleted_successfuly')]);
    }



}
