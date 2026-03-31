<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\User\UserResource;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->respondError(
                'اطلاعات وارد شده اشتباه است',
                422
            );
        }

        return $this->returnLoginResponse($user, $request);
    }

    public function register(RegisterRequest $request)
    {
        $data             = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        event(new Registered($user));

        return $this->returnLoginResponse($user, $request);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondSuccess('logout successfull');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'prev_password' => 'required',
            'password'      => 'required|min:8|confirmed'
        ]);

        if (!Hash::check($request->prev_password, $request->user()->password)) {
            throw ValidationException::withMessages(['prev_password' => 'رمز عبور فعلی وارد شده اشتباه است']);
        }

        $password = Hash::make($request->password);

        $request->user()->update([
            'password'       => $password,
            'remember_token' => Str::random(60),
        ]);

        $current_token = $request->user()->currentAccessToken();

        $request->user()->tokens()->where('id', '!=', $current_token->id)->delete();

        return $this->respondSuccess('رمز عبور با موفقیت تغییر یافت');
    }

    private function returnLoginResponse(User $user, Request $request)
    {
        $data = [
            'result' => [
                'token' => $user->createToken($request->device_name ?: 'unknown')->plainTextToken,
                'user'  => new UserResource($user)
            ],
        ];

        return $this->apiResponse($data);
    }
}
