<?php

namespace App\Modules\Governance\Http\Repositories\Member;

use App\Modules\Governance\Http\Requests\Member\MemberRequest;
use App\Modules\Governance\Http\Requests\Member\AssigneAsDirectorRequest;
use App\Modules\HR\Entities\Employee;
use App\Repositories\CommonRepositoryInterface;

interface MemberRepositoryInterface extends CommonRepositoryInterface
{
    public function updateMember(MemberRequest $request, Employee $employee);
    public function assignAsDirector(AssigneAsDirectorRequest $request, Employee $employee);
    public function getSingleMember($id);
    public function getActiveDirectories();
}
