<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserGetByIdRequest;
use App\Http\Requests\UserGetNameRequest;
use App\Http\Requests\UserGetRegistrationDateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    private $user;
    private $service;

    public function __construct(User $user, UserService $service) {
        $this->user = $user;
        $this->service = $service;
    }

    public function getById(UserGetByIdRequest $request){
        return $this->service->getById($request);
    }
    // public function getById(UserGetByIdRequest $request){
    //     return new CustomerResource(
    //         $this->user->find($request->id),
    //     );
    // }

    public function getByName(UserGetNameRequest $request){
        return $this->service->getByName($request);
    }

    public function getByRegistrationDate(UserGetRegistrationDateRequest $request){
        return $this->service->getByRegistrationDate($request);
    }
    // public function getByRegistrationDate(UserGetRegistrationDateRequest $request){
    //     return CustomerResource::collection(
    //         $this->user->where('registration_date', $request->registration_date)->get()
    //     );
    // }

    public function store(UserRequest $request){
        $userCreated = $this->service->store($request);

        if(!$userCreated) return response(['error'=>'nao foi possivel criar o usuario'])->setStatusCode(401);

        return response(['message'=>'usuario e endereco criado com sucesso'])->setStatusCode(201);
    }
    // public function store(UserRequest $request){
    //     $userExist = $this->user->where('cpf', $request['cpf'])->first();

    //     if($userExist) return response(['error'=>'usuario ja existe'])->setStatusCode(401);

    //     $userCreated = $this->user->create($request->all());

    //     if(!$userCreated) return response(['error'=>'nao foi possivel criar o usuario'])->setStatusCode(401);

    //     $userCreated->address()->create($request->address);

    //     return response(['message'=>'usuario e endereco criado com sucesso'])->setStatusCode(201);
    // }

    public function update(UserUpdateRequest $request){
        $userUpdated = $this->service->update($request);

        if(!$userUpdated) return response(['error'=>'usuario nao foi atualizado'])->setStatusCode(401);

        return response(['message'=>'usuario atualizado com sucesso'])->setStatusCode(200);
    }
    // public function update(UserUpdateRequest $request){
    //     $userExist = $this->user->find($request->id);

    //     if(!$userExist) return response(['error'=>'usuario nao existe'])->setStatusCode(404);

    //     $userUpdated = $userExist->update($request->all());

    //     if(!$userUpdated) return response(['error'=>'usuario nao foi atualizado'])->setStatusCode(401);

    //     return response(['message'=>'usuario atualizado com sucesso'])->setStatusCode(200);
    // }

    public function destroy(UserDeleteRequest $request){
        $userDeleted = $this->service->destroy($request);

        if(!$userDeleted) return response(['error'=>'usuario nao foi excluido'])->setStatusCode(401);

        return response(['message'=>'usuario excluido com sucesso'])->setStatusCode(200);
    }
    // public function destroy(UserDeleteRequest $request){
    //     $userExist = $this->user->find($request->id);

    //     if(!$userExist) return response(['error'=>'usuario nao existe'])->setStatusCode(404);

    //     $userDeleted = $userExist->delete();

    //     if(!$userDeleted) return response(['error'=>'usuario nao foi excluido'])->setStatusCode(401);

    //     return response(['message'=>'usuario excluido com sucesso'])->setStatusCode(200);
    // }
}
