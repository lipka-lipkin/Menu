<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AuthLoginRequest;
use App\Http\Resources\Admin\UserResource;

class AuthController extends Controller
{
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
