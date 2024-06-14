<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

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

    public function update(UserUpdateRequest $request){
        $userExist = $this->user->find($request->id);

        if(!$userExist) return response(['error'=>'usuario nao existe'])->setStatusCode(404);

        $userUpdated = $userExist->update($request->all());

        if(!$userUpdated) return response(['error'=>'usuario nao foi atualizado'])->setStatusCode(401);

        return response(['message'=>'usuario atualizado com sucesso'])->setStatusCode(200);
    }

    public function destroy(UserDeleteRequest $request){
        $userExist = $this->user->find($request->id);

        if(!$userExist) return response(['error'=>'usuario nao existe'])->setStatusCode(404);

        $userDeleted = $userExist->delete();

        if(!$userDeleted) return response(['error'=>'usuario nao foi excluido'])->setStatusCode(401);

        return response(['message'=>'usuario excluido com sucesso'])->setStatusCode(200);
    }
}
