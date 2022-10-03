<?php

namespace App\Modules\HR\Http\Repositories\TrainingCourse;

use App\Modules\HR\Entities\TrainingCourse;
use App\Foundation\Classes\Helper;
use App\Modules\HR\Entities\TrainingCourseTranslation;
use App\Repositories\CommonRepository;
use App\Modules\HR\Http\Repositories\TrainingCourse\TrainingCourseReporitoryInterface;
use App\Modules\HR\Transformers\TrainingCourse\TrainingCourseCollection;
use App\Modules\HR\Transformers\TrainingCourse\TrainingCourseResource;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Foundation\Traits\ImageTrait;

class TrainingCourseRepository extends CommonRepository implements TrainingCourseReporitoryInterface
{
    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            $this->translated('course_name'),
            'from_date',
            'to_date'
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            $this->translated('course_name'),
            'from_date',
            'to_date',
        ];

    }

    public function index(){
        $data =  $this->setfilters()->defaultSort('-id')
        ->allowedSorts('id','from_date','to_date')->paginate(Helper::PAGINATION_LIMIT);
        $trainingCourses = TrainingCourseResource::collection($data);
        return $this->paginateResponse($trainingCourses, $data);
    }

    public function store($request)
    {
        return DB::transaction(function() use($request){
            isset($request['attachments']) ?
        $Readydata = collect($request)->except('attachments')->toArray()
        : $Readydata = collect($request)->toArray();

        $trainingCourse = $this->model->create($Readydata);
       if ($trainingCourse && isset($request['attachments'])) {

        $fileNames = [];
        foreach ($request['attachments'] as $attachment) {
            array_push($fileNames, $this->storeImage($attachment, 'training_course'));
        }

        $trainingCourse->attachments = implode('|', $fileNames);
        $trainingCourse->save();
        }
        return $this->successResponse(null, true, 'added success');
        });
    }

    public function update($request, $id)
    {
        return DB::transaction(function() use($request,$id){
        $updated = $this->model->find($id)->update($request);
        if (!$updated) {
            return $this->errorResponse(null, false, 'not updated!');
        }
        return $this->successResponse(null, true, 'updated success');
        });
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        $translations = TrainingCourseTranslation::where('training_course_id',$id)->get();
        foreach($translations as $translation){
            $translation->delete();
        }
    }

    public function model()
    {
        return TrainingCourse::class;
    }
}
