<?php

namespace App\Modules\HR\Http\Repositories\HoldHarmless;

use App\Repositories\CommonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface HoldHarmlessRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function show($id);
    public function archive(Request $request);
    public function restore($id);
    public function store($data);
    public function remove($id);
    public function storeStatusDM($data, $id);
    public function storeStatusHR($data, $id);
    public function storeStatusIT($data, $id);
    public function storeStatusLegal($data, $id);
    public function storeStatusFinance($data, $id);
}
