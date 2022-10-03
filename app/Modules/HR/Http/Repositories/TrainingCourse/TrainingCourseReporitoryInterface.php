<?php

namespace App\Modules\HR\Http\Repositories\TrainingCourse;

use App\Repositories\CommonRepositoryInterface;

interface TrainingCourseReporitoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function destroy($id);
}
