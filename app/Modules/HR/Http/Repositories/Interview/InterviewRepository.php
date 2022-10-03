<?php

namespace App\Modules\HR\Http\Repositories\Interview;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\CustomSorts\InterviewCountApplicantsSort;
use App\Modules\HR\CustomSorts\InterviewCountCandidatesSort;
use App\Modules\HR\CustomSorts\InterviewJobNameSort;
use App\Modules\HR\CustomSorts\InterviewManagementNameSort;
use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Entities\Interviews\InterviewApplicationItem;
use App\Modules\HR\Entities\Interviews\InterviewCommitteeMember;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Http\Requests\InterviewRequest;
use App\Repositories\CommonRepository;
use Carbon\Carbon;
use App\Modules\HR\Transformers\Interview\InterviewApplicationResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class InterviewRepository extends CommonRepository implements InterviewRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'add_by_id',
            'id',
            'job_id',
            'applications.name',
            'committeeMembers.id',
            AllowedFilter::scope('created_date'),
            AllowedFilter::scope('name_candidate'),
            AllowedFilter::scope('management_id')
        ];
    }

    public function sortColumns()
    {
        return [
            'created_at',
            AllowedSort::custom('management-name', new InterviewManagementNameSort(), 'name'),
            AllowedSort::custom('job-name', new InterviewJobNameSort(), 'name'),
            AllowedSort::custom('count-applicants', new InterviewCountApplicantsSort(), 'applications_count'),
            AllowedSort::custom('count-candidates', new InterviewCountCandidatesSort(), 'count_candidates'),

            'add_by_id',
            'job_id',
            'identity_number',
            'name',
            'mobile',
        ];
    }

    public function model()
    {
        return Interview::class;
    }


    public function indexInteviewApplication(Request $request)
    {
        $interveiws = InterviewApplication::setFilters()->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(InterviewApplicationResource::collection($interveiws), $interveiws);
    }

    private function createMembers($members, $interview)
    {
        foreach ($members['members'] as $member) {
            InterviewCommitteeMember::create(['member_id' => $member, 'interview_id' => $interview->id]);
        }
    }

    private function createApplications($applications, $interview)
    {
        foreach ($applications['applications'] as $application) {
            $items = $application['items'];
            unset($application['items']);
            $application = InterviewApplication::create($application + ['interview_id' => $interview->id]);
            $sum_scores = 0;
            foreach ($items as $item) {
                InterviewApplicationItem::create($item + ['interview_application_id' => $application->id]);
                $sum_scores += $item['score'];
            }
            $application->update(['total_score' => $sum_scores]);
        }
    }

    private function updateApplications($applications, $interview)
    {
        foreach ($applications['applications'] as $application) {
            $items = $application['items'];
            $application_id = $application['id'];
            unset($application['items'], $application['id']);
            $application_update = InterviewApplication::find($application_id);
            $application_update->update($application + ['interview_id' => $interview->id]);
            InterviewApplicationItem::where('interview_application_id', $application_id)->delete();
            $sum_scores = 0;
            foreach ($items as $item) {
                InterviewApplicationItem::create($item + ['interview_application_id' => $application_id]);
                $sum_scores += $item['score'];
            }
            $application_update->update(['total_score' => $sum_scores]);
        }
    }


    public
    function store(InterviewRequest $request)
    {
        $job = $request->safe()->only('job_id');
        $members = $request->safe()->only('members');
        $applications = $request->safe()->only('applications');

        $interview = $this->create($job + ['added_by_id' => \Auth::id()]);
        $this->createMembers($members, $interview);
        $this->createApplications($applications, $interview);

        return $interview;
    }


    public function show($id)
    {
        return $this->findOrFail($id)->load('addedBy', 'job', 'committeeMembers', 'applications');
    }

    public
    function edit($id)
    {
        return $this->findOrFail($id)->load('addedBy', 'job', 'committeeMembers', 'applications');
    }

    public
    function updateInterview(InterviewRequest $request, $id)
    {
        $interview = $this->find($id);
        $job = $request->safe()->only('job_id');
        $members = $request->safe()->only('members');
        $applications = $request->safe()->only('applications');
        $interview->update([$job]);

        InterviewCommitteeMember::where('interview_id', $interview->id)->delete();
        $this->createMembers($members, $interview);
        $this->updateApplications($applications, $interview);
        return $interview;
    }

    public
    function destroy($id)
    {
        return $this->delete($id);
        //  return $this->successResponse(['message' => __('hr::messages.management.deleted_successfuly')]);
    }


}
