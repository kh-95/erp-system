<?php

namespace App\Modules\Secretariat\Http\Repositories\Message;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Secretariat\Entities\Message;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Secretariat\Transformers\Message\MessageResource;

class MessageRepository extends CommonRepository implements MessageRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'message_number',
            'source',
            'message_date',
            'message_recieve_date',
            'message_body',
        ];
    }

    public function sortColumns()
    {

        return [
            'id',
            'message_number',
            'source',
            'message_date',
            'message_recieve_date',
            'message_body'
        ];

    }

    public function model()
    {
        return Message::class;
    }

    public function index(Request $request){
        $messages = $this->setFilters()->defaultSort('-created_at')
        ->with(['claimant', 'legal', 'defendant', 'specialist', 'activities'])
        ->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(MessageResource::collection($messages), $messages);
    }

    public function store($data)
    {
            $message = $this->create($data);
            $message->claimant()->create($data['claimant']);
            $message->legal()->create($data['legal']);
            $message->defendant()->create($data['defendant']);
            $message->specialist()->create($data['specialist']);

            $message->load(['claimant', 'legal', 'defendant', 'specialist', 'activities']);
            return $this->successResponse(new MessageResource($message), message : trans('secretariat::messages.messageDefault.added_successfuly'));
    }

    public function show($id)
    {
        $message = $this->find($id)->load(['claimant', 'legal', 'defendant', 'specialist']);
        return $this->successResponse(new MessageResource($message));
    }

    public function edit($data, $id)
    {
            $message = $this->find($id);
            $message->update($data);
            isset($data['claimant']) ? $message->claimant()->update($data['claimant']) : '';
            isset($data['legal']) ? $message->legal()->update($data['legal']) : '';
            isset($data['defendant']) ? $message->defendant()->update($data['defendant']) : '';
            isset($data['specialist']) ? $message->specialist()->update($data['specialist']) : '';
            $message->load(['claimant', 'legal', 'defendant', 'specialist', 'activities']);
            return $this->successResponse(new MessageResource($message) , message : trans('secretariat::messages.messageDefault.edit_successfuly'));
    }

    public function destroy($id)
    {
        $this->delete($id);
        return $this->successResponse(['message' => __('secretariat::messages.messageDefault.deleted_successfuly')]);
    }

    public function restore($id)
    {
        $record = $this->withTrashed()->find($id)->restore();
        return $this->successResponse(['message' => __('secretariat::messages.messageDefault.restored_successfuly')]);
    }
}
