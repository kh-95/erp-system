<?php

namespace App\Repositories;

use App\Foundation\Classes\FilterAmountBetween;
use App\Foundation\Classes\FilterTotalPaysBetween;
use App\Foundation\CustomSort\SortTranslatedColumn;
use App\Foundation\Classes\FilterCreatedAtBetween;
use App\Foundation\Classes\FilterDeactivatedAt;
use App\Foundation\Classes\FilterTranslatedCulmon;
use App\Foundation\Classes\Helper;
use App\Foundation\CustomSort\sortUsingRelationship;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\DeactivatedTrait;
use App\Transformers\ActivityResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use App\Modules\Governance\CustomFilter\FilterPlanAtBetween;

class CommonRepository extends BaseRepository implements CommonRepositoryInterface
{
    use DeactivatedTrait;

    public function setFilters()
    {
        return QueryBuilder::for($this->getModel())->allowedFilters($this->filterColumns());
    }

    protected function filterColumns()
    {
    }

    public function createdAtBetween($value)
    {
        return AllowedFilter::custom($value, new FilterCreatedAtBetween);
    }

   

    public function amountBetween($value)
    {
        return AllowedFilter::custom($value, new FilterAmountBetween);
    }

    public function totalPaysBetween($value)
    {
        return AllowedFilter::custom($value, new FilterTotalPaysBetween());
    }

    public function deactivatedAt($value)
    {
        return AllowedFilter::custom($value, new FilterDeactivatedAt);
    }

    public function translated($culomn)
    {
        return AllowedFilter::custom($culomn, new FilterTranslatedCulmon);
    }

    public function sortingTranslated($alias, $column)
    {
        return AllowedSort::custom($alias, new SortTranslatedColumn(), $column);
    }

    public function sortUsingRelationship($alias, $column)
    {
        return AllowedSort::custom($alias, new sortUsingRelationship(), $column);
    }


    public function model()
    {
        // TODO: Implement model() method.
    }

    public function forExternalServices(array $attributes)
    {
        return $this->scopeActive($this->model->select($attributes)->get());
    }

    public function toggleStatus($id)
    {
        $record = $this->find($id);
        $status = (bool)$record->deactivated_at;
        $record->update([
            'deactivated_at' => !$status
        ]);
    }

    public function deactive($id)
    {
        $record = $this->find($id);
        $record->update([
            'deactivated_at' => now()
        ]);
    }

    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }

    public function doesntHaveRelations(int $id, array $relations): bool
    {
        $record = $this->model->withTrashed()->find($id)->loadExists($relations);
        foreach ($relations as $relation) {
            $relationExists = $relation . '_exists';
            if ($record->$relationExists) {
                return false;
            }
        }
        return true;
    }

    public function recordActivities($id)
    {
        $activities = $this->model->find($id)->activities()->latest()->paginate(Helper::PAGINATION_LIMIT);
        $data = ActivityResource::collection($activities);
        return $this->paginateResponse($data, $activities);
    }
}
