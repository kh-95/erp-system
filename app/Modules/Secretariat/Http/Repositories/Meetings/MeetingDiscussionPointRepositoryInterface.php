<?php

namespace App\Modules\Secretariat\Http\Repositories\Meetings;

use App\Repositories\CommonRepositoryInterface;

interface MeetingDiscussionPointRepositoryInterface extends CommonRepositoryInterface
{
   public function store($data, $meeting_id);
   public function editDissusion($data, $id);
   public function deleteDissusion($id);
}
