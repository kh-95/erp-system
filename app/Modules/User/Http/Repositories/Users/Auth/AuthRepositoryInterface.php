<?php

namespace App\Modules\User\Http\Repositories\Users\Auth;

use App\Modules\User\Http\Requests\Auth\AcceptForgetPasswordRequest;
use App\Modules\User\Http\Requests\Auth\ForgetPasswordRequest;
use App\Modules\User\Http\Requests\Auth\LoginRequest;
use App\Modules\User\Http\Requests\Auth\ValidateOtpRequest;

interface AuthRepositoryInterface
{
    public function login($request);
    public function acceptForgetPassword(AcceptForgetPasswordRequest $request);
    public function validateOtp(ValidateOtpRequest $request);
    public function forgetPassword(ForgetPasswordRequest $request);
    public function logout();
}
