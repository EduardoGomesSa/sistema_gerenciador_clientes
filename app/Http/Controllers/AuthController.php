<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response(['error'=>'O e-mail informado não está cadastrado'], 401);
        }

        if($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth-token')->plainTextToken;
            $user->token = $token;

            return new UserResource($user);
        }

        return response(['error'=>'A senha informada está incorreta'], 401);
    }

    public function validateToken(Request $request)
    {
        if($token = $request->bearerToken()) {
            $user = auth('sanctum')->user();
            $user->token = $token;
            return new UserResource($user);
        }
    }

    public function logout()
    {
        /** @var User $user */
        $user = Auth()->user();
        $user->tokens()->delete();

        return response(['message'=>'Logout realizado com sucesso'], 200);
    }
}
