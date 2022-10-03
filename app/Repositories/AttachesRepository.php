<?php

namespace App\Repositories;

use App\Foundation\Traits\ImageTrait;

class AttachesRepository implements AttachesRepositoryInterface
{
    use ImageTrait;
    public $type;
    public function __construct(private string $location, private $request, private $model)
    {
        $this->type = $request->file_type ?: 'image';
    }
    public function addAttaches()
    {
        $type = $this->type;
        $attachments = collect($this->request->attachments)->map(function ($item) use ($type) {
            $data['file'] = $this->storeImage($item, $this->location, $type);
            $data['type'] = $type;
            return $data;
        })->values()->toArray();
        $this->model->attachments()->createMany($attachments);
        return $this->model;
    }

    public function deleteAttachment($attachments)
    {

            $attachments->map(function ($item) {
                $this->deleteImage($item->file, $this->location);
                $item->delete();
            });

    }
}
