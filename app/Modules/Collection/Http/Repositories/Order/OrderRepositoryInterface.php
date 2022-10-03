<?php

namespace App\Modules\Collection\Http\Repositories\Order;

use App\Repositories\CommonRepositoryInterface;

interface OrderRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
    public function store($data);
    public function edit($data, $id);
    public function show($id);
    public function removeAttachment($id);
    public function getCustomerByMobile($mobile);
    public function getCustomerByIdentity($identity);
}
