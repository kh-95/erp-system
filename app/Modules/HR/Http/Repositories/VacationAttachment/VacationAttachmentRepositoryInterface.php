<?php

namespace App\Modules\HR\Http\Repositories\VacationAttachment;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface VacationAttachmentRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
    public function changeStatus($id);
}
