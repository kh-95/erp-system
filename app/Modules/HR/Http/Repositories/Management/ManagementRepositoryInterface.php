<?php

namespace App\Modules\HR\Http\Repositories\Management;

use App\Repositories\CommonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ManagementRepositoryInterface extends CommonRepositoryInterface
{
    public function checkManagementName(string $name);
    public function deactivated_at($id);
    public function destroy($id);
    public function listManagement(): Collection;
}
