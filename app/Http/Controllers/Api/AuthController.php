<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthLoginRequest;
use App\Http\Requests\Api\Auth\AuthRegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\User;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return UserResource::make($user->makeToken());
    }

    public function login(AuthLoginRequest $request)
    {
        $data = $request->only('email', 'password');
        if (!auth()->attempt($data)) {
            return ResponseHelper::validation(['credentials' => __('validation.attributes.incorrect_credentials')]);
        }
        $user = auth()->user();
        return UserResource::make($user->makeToken());
    }
}
