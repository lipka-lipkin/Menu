<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AuthLoginRequest;
use App\Http\Resources\Admin\UserResource;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $data = $request->only('email', 'password');
        if (!auth()->attempt($data))
        {
            $error = [
                ['message'=>'The given data was invalid.'],
                ['errors' => ['credentials' => 'incorrect credentials']]
            ];
            return response($error, 422);
        }
        $user = auth()->user();
        return UserResource::make($user->makeToken());
    }
}
