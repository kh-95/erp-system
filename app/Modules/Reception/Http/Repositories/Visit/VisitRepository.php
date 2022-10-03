<?php

namespace App\Modules\Reception\Http\Repositories\Visit;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Entities\Visitor;
use App\Modules\Reception\Http\Requests\Visit\StoreRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateRequest;
use App\Modules\Reception\Http\Requests\Visit\UpdateStatusRequest;
use App\Modules\Reception\Transformers\VisitResource;
use App\Repositories\CommonRepository;
use App\Modules\Reception\Http\Repositories\Visit\VisitRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitRepository extends CommonRepository implements VisitRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'date',
            'management_id',
            $this->translated('type'),
            $this->translated('note'),
            'status',
            'visitors.name',
            'visitors.identity_number',
        ];
    }

    public function model()
    {
        return Visit::class;
    }

    public function index(Request $request){
        $visits = $this->setFilters()->defaultSort('-created_at')
        ->allowedSorts(['id', 'date', $this->sortingTranslated('type','type'),$this->sortingTranslated('note','note'),
        'management_id', 'status'])->with(['visitors','employees'])
        ->paginate(Helper::getPaginationLimit($request));
        return $this->successResponse([
            'visits' => VisitResource::collection($visits),
            'pagination' => [
                'total' => $visits->total(),
                'count' => $visits->count(),
                'per_page' => $visits->perPage(),
                'current_page' => $visits->currentPage(),
                'total_pages' => $visits->lastPage()
            ],
        ]);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $Readydata = collect($data)->except('date','time', 'time_type')->toArray();
            $Readydata['date'] = Helper::ConcatenateDateTime($data['date'], $data['time'], $data['time_type'],'Y-m-d H:i');
            $visit = $this->create($Readydata);
            $visit->visitors()->createMany($Readydata['visitors']);
            $visit->employees()->attach($Readydata['employees']);
            $visit->load('visitors', 'employees', 'activities');
            return $this->successResponse(new VisitResource($visit), message : trans('reception::messages.messageDefault.added_successfuly_visit'));
        });
    }

    public function show($id)
    {
        $visit = $this->find($id)->load(['visitors', 'employees']);
        return $this->successResponse(new VisitResource($visit));
    }

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data,$id){
            $Readydata = $data;
            if(isset($data['date'])){
             $Readydata = collect($data)->except('date','time', 'time_type')->toArray();
             $Readydata['date'] = Helper::ConcatenateDateTime($data['date'], $data['time'], $data['time_type'],'Y-m-d H:i');
            }
            $visit = $this->find($id);
            $visit->update($Readydata);
            $visit->employees()->sync($Readydata['employees']);
            $visit->load(['visitors', 'employees', 'activities']);
            return $this->successResponse(new VisitResource($visit) , message : trans('reception::messages.messageDefault.edit_successfuly_visit'));
        });
    }

    public function editٍStatus($data, $id)
    {
      $visit =  $this->update($data,$id);
      return $this->successResponse(new VisitResource($visit), message : trans('reception::messages.messageDefault.edit_successfuly_statusVisit'));
    }

    public function destroy($id)
    {
        $this->delete($id);
        return $this->successResponse(['message' => __('reception::messages.messageDefault.deleted_successfuly_visit')]);
    }

    public function editVisit($id)
    {
        $visit = $this->find($id);
        return $this->successResponse(new VisitResource($visit));
    }

    public function restore($id)
    {
        $record = $this->withTrashed()->find($id)->restore();
        return $this->successResponse(['message' => __('reception::messages.messageDefault.restored_successfuly')]);
    }
}
