<?php

namespace App\Modules\Reception\Http\Repositories\ReceptionReport;

use App\Repositories\CommonRepositoryInterface;

interface ReceptionReportRepositoryInterface extends CommonRepositoryInterface
{
    public function store(array $attr) ;
    public function updateReceptionReport(array $attr ,$id);
    public function updateStatus($status,$id);
    public function destroy($id) ;
    public function restore($id);
}
