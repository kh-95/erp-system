<?php

namespace App\Modules\CustomerService\Http\Repositories\Message;


use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\CustomerService\Entities\Message;
use App\Modules\CustomerService\Http\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\CommonRepository;
use Illuminate\Support\Arr;

class MessageRepository extends CommonRepository implements MessageRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'name',
            'identity_number',
            'phone',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            'text',
            'type',
            'employee.fullname'
        ];
    }

    public function sortColumns()
    {
        return [
            'name',
            'identity_number',
            'phone',
            'created_at',
            'text',
            'type',
            'employee.fullname'
        ];
    }

    public function model()
    {
        return Message::class;
    }

    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }
}
