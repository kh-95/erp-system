<?php

namespace App\Modules\User\Http\Repositories\Users\Auth;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\User\Entities\User;
use App\Modules\HR\Entities\Employee;
use App\Modules\User\Http\Requests\Auth\ForgetPasswordRequest;
use App\Modules\User\Http\Requests\Auth\AcceptForgetPasswordRequest;
use App\Modules\User\Http\Requests\Auth\LoginRequest;
use App\Modules\User\Http\Requests\Auth\ValidateOtpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use App\Modules\User\Transformers\UserResource;

class AuthRepository implements AuthRepositoryInterface
{
    use ApiResponseTrait;

    public function login($request)
    {
        $user = User::where('employee_number', $request['employee_number'])->first();

        if (!Hash::check($request['password'], $user->password)) {
            $this->hitRateLimiter($user);

            if ($this->checkTooManyFailedAttempts($user)) {
                return $this->errorResponse(trans("user::auth.user_blocked"), 401);
            }

            return $this->errorResponse(trans("user::auth.invalid_credentials"), 401);
        }

        if ($user->deactivated_at) {
            return $this->errorResponse(trans("user::auth.user_disable"), 401);
        }

        if (!$user->is_send_otp || ($request->has('otp') && $user->otp == $request['otp'])) {
            RateLimiter::clear($this->throttleKey());
            $user->update(['otp' => null]);
            $user->token = $user->createToken('LaravelSanctumAuth')->plainTextToken;
            return $this->successResponse(data: UserResource::make($user));
        }

        if ($user->is_send_otp && $user->otp === null) {
            $user->update(['otp' => 12345]);
            return $this->successResponse(["type" => "send_otp"]);
        }

        return $this->errorResponse(trans('user::invalid_otp'));
    }

    public function acceptForgetPassword(AcceptForgetPasswordRequest $request)
    {
        $user = User::whereHas('employee', function ($query) use ($request) {
            $query->where('phone', $request->phone);
        })->first();

        if ($user) {
            $user->update(['otp' => 12345]);
            return $this->successResponse("send_otp");
        }

        return $this->errorResponse(trans('user::auth.phone_not_found'));
    }

    public function validateOtp(ValidateOtpRequest $request)
    {
        $user = User::whereHas('employee', function ($query) use ($request) {
                $query->where('phone', $request->phone);
            })
            ->where('otp', $request->otp)
            ->first();

        if($user) {
            return $this->successResponse(true);
        }
        return $this->errorResponse(trans('user::invalid_otp'));
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $user = User::whereHas('employee', function ($query) use ($request) {
            $query->where('phone', $request->phone);
        })->where('otp', $request->otp)->first();

        if ($user) {
            $user->update([
                'otp' => null,
                'password' => $request->password,
            ]);
            return $this->successResponse(true);
        }
        return $this->errorResponse(trans('user::invalid_otp'));
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse(true);
    }

    private function throttleKey()
    {
        return 'employee_number:' . request()->employee_number;
    }

    private function checkTooManyFailedAttempts(User $user) :bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 3) || $user->blocked_key;
    }

    private function hitRateLimiter(User $user)
    {
        RateLimiter::hit($this->throttleKey());
        if ($this->checkTooManyFailedAttempts($user)) {
            $user->update([
                'blocked_key' => 'blocked_key'
            ]);
        }
    }
}
