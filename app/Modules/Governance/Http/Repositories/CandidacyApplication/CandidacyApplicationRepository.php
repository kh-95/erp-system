<?php

namespace App\Modules\Governance\Http\Repositories\CandidacyApplication;

use App\Repositories\CommonRepository;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use App\Modules\Governance\Entities\CandidacyApplication;
use App\Modules\Governance\Entities\CandidacyAttachment;
use App\Modules\Governance\Http\Repositories\CandidacyApplication\CandidacyApplicationRepositoryInterface;
use App\Modules\Governance\Http\Requests\CandidacyApplicationRequest;
use App\Modules\Governance\Transformers\CandidacyApplicationResource;
use Arr;

class CandidacyApplicationRepository extends CommonRepository implements CandidacyApplicationRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'candidate_name',
            'identity_number',
            'phone',
            'qualification_level',
            'is_active',
            'nationality_id',
            'created_at',
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            'candidate_name',
            'identity_number',
            'phone',
            'qualification_level',
            'is_active',
            'created_at',
        ];
    }

    public function model()
    {
        return CandidacyApplication::class;
    }



    public function store(CandidacyApplicationRequest $request)
    {
        $data = $request->all();
        $candidacy = $this->model()::create(Arr::except($data, ['attachments', 'file_type']));
        $this->storeRelationships($request, $candidacy);

        return $candidacy;
    }


    public function show($id)
    {
       $candidacy_request = $this->find($id);
       return $this->apiResource(CandidacyApplicationResource::make($candidacy_request),true);
    }
    public function edit($id)
    {
        $candidacy_request = $this->find($id);
        return $this->apiResource(CandidacyApplicationResource::make($candidacy_request),true);
    }


    public function updateCandidacyRequset(CandidacyApplicationRequest $request, $id)
    {
        $candidacyRequest = $this->find($id);
        $data = $request->validated();
        $candidacyRequest->update(Arr::except($data, ['attachments', 'file_type']));

        $this->storeRelationships($request, $candidacyRequest);

        return $candidacyRequest;
    }

    private function storeRelationships($request, CandidacyApplication $candidacy)
    {
        if ($request->isMethod('PUT')) {
            $candidacy->attachments()->delete();
            $candidacy->attachments->map(function ($item, $key) {
                $this->deleteImage($item, 'governance_candidacy_applications');
            });
        }

        if ($request->has('attachments') && $request->attachments != null) {
            $attachments = collect($request->attachments)->map(function ($item, $key) {
                $data['media'] = $this->storeImage($item, 'governance_candidacy_applications');
                $data['type'] = $key;
                return $data;
            })->values()->toArray();

            $candidacy->attachments()->createMany($attachments);
        }
    }

    public function destroy($id)
    {
        $candidacy = $this->find($id);
        $files = $candidacy->attachments;
        foreach ($files as $file) {
            $this->deleteFile($file->media, $file->type, CandidacyApplication::CANDIDACYAPPLICATION);
        }
        return   $candidacy->delete($id);

    }
    public function deleteAttachmentCandidacy($id)
    {
        $file = CandidacyAttachment::find($id);
        $this->deleteFile($file->media, $file->type, CandidacyApplication::CANDIDACYAPPLICATION);
        $file->delete();
    }
}
