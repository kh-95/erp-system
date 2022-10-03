<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Http\Repositories\Users\Auth\AuthRepositoryInterface;
use App\Modules\User\Http\Requests\Auth\AcceptForgetPasswordRequest;
use App\Modules\User\Http\Requests\Auth\ForgetPasswordRequest;
use App\Modules\User\Http\Requests\Auth\LoginRequest;
use App\Modules\User\Http\Requests\Auth\ValidateOtpRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }

    public function acceptForgetPassword(AcceptForgetPasswordRequest $request)
    {
        return $this->authRepository->acceptForgetPassword($request);
    }

    public function validateOtp(ValidateOtpRequest $request)
    {
        return $this->authRepository->validateOtp($request);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->authRepository->forgetPassword($request);
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }

}
