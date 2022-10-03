<?php

namespace App\Modules\HR\Http\Repositories\Job;

use App\Repositories\CommonRepositoryInterface;

interface JobRepositoryInterface extends CommonRepositoryInterface
{
   public function deactivated_at($id) ;
   public function destroy($id) ;
}
