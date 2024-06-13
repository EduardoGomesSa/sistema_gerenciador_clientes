<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function store(UserRequest $request){
        $userExist = $this->user->where('cpf', $request['cpf'])->first();

        if($userExist) return response(['error'=>'usuario ja existe'])->setStatusCode(401);

        $userCreated = $this->user->create($request->all());

        if(!$userCreated) return response(['error'=>'nao foi possivel criar o usuario'])->setStatusCode(401);

        $userCreated->address()->create($request->address);

        return response(['message'=>'usuario e endereco criado com sucesso'])->setStatusCode(201);
    }
}
