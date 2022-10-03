<?php

namespace App\Modules\HR\Http\Repositories\Interview;


use App\Modules\HR\Http\Requests\InterviewRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface InterviewRepositoryInterface extends CommonRepositoryInterface
{

    public function indexInteviewApplication(Request $request);
    public function store(InterviewRequest $request);
    public function updateInterview(InterviewRequest $request, $id);
    public function edit($id);
    public function show($id);
    public function destroy($id);

}
