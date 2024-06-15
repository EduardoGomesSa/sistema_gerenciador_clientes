<?php

namespace App\Services;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserGetByIdRequest;
use App\Http\Requests\UserGetNameRequest;
use App\Http\Requests\UserGetRegistrationDateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Models\User;

class UserService{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    private function userExistByCpf($cpf) : bool {
        return $this->user->where('cpf', $cpf)->first() != null;

        return false;
    }

    private function userExist($id) : bool {
        return $this->user->find($id) != null;

        return false;
    }

    // public function getById($id){
    //     return  $this->user->find($id);
    // }

    public function getById(UserGetByIdRequest $request){
        return new CustomerResource(
            $this->user->find($request->id),
        );
    }

    public function getByName(UserGetNameRequest $request){
        return CustomerResource::collection(
            $this->user->where('name', 'LIKE', "$request->name%")->get()
        );
    }

    public function getByRegistrationDate(UserGetRegistrationDateRequest $request){
        return CustomerResource::collection(
            $this->user->where('registration_date', $request->registration_date)->get()
        );
    }

    public function store(UserRequest $request){
        $userExist = $this->userExistByCpf($request['cpf']);

        if($userExist) return null;

        $userCreated = $this->user->create($request->all());

        if(!$userCreated) return null;

        $userCreated->address()->create($request->address);

        return $userCreated;
    }

    public function update(UserUpdateRequest $request){
        $userExist = $this->userExist($request['id']);

        if(!$userExist) return false;

        $user = $this->user->find($request['id']);

        $userUpdated = $user->update($request->all());

        if($userUpdated > 0) return true;

        return false;
    }

    public function destroy(UserDeleteRequest $request){
        $userExist = $this->userExist($request['id']);

        if(!$userExist) return false;

        $user = $this->user->find($request['id']);

        $userDeleted = $user->delete();

        if($userDeleted > 0) return true;

        return false;
    }
}