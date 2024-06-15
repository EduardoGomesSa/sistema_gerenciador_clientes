<?php

namespace App\Services;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserGetByIdRequest;
use App\Http\Requests\UserGetNameRequest;
use App\Http\Requests\UserGetRegistrationDateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Address;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private $user;
    private $repository;

    public function __construct(User $user, UserRepository $repository)
    {
        $this->user = $user;
        $this->repository = $repository;
    }

    public function getById(UserGetByIdRequest $request)
    {
        return new CustomerResource(
            $this->repository->getById($request->id),
        );
    }

    public function getByName(UserGetNameRequest $request)
    {
        return CustomerResource::collection(
            $this->user->where('name', 'LIKE', "$request->name%")->get()
        );
    }

    public function getByRegistrationDate(UserGetRegistrationDateRequest $request)
    {
        return CustomerResource::collection(
            $this->user->where('registration_date', $request->registration_date)->get()
        );
    }

    public function store(UserRequest $request)
    {
        $user = $this->convertToCreate($request);

        $userCreated = $this->repository->store($user);

        if (!$userCreated) return null;

        return $userCreated;
    }

    
    public function update(UserUpdateRequest $request)
    {
        $userExist = $this->repository->userExistById($request['id']);

        if (!$userExist) return false;

        $user = $this->user->find($request['id']);

        $userUpdated = $user->update($request->all());

        if ($userUpdated > 0) return true;

        return false;
    }

    // public function update(UserUpdateRequest $request)
    // {
    //     $userExist = $this->repository->userExistById($request['id']);

    //     if (!$userExist) return false;

    //     $userReturned = $this->repository->getById($request['id']);

    //     $userToUpdate = $this->convertToUpdate($request, $userReturned);

    //     $userUpdated = $this->repository->update($userToUpdate);

    //     return $userUpdated;
    // }

    public function destroy(UserDeleteRequest $request)
    {
        $userExist = $this->repository->userExistById($request['id']);

        if (!$userExist) return false;

        $user = $this->user->find($request['id']);

        $userDeleted = $user->delete();

        if ($userDeleted > 0) return true;

        return false;
    }

    // private function convertToUpdate(UserUpdateRequest $request, User $user) : User{
    //     if ($request->filled('name')) {
    //         $user->name = $request->name;
    //     }

    //     if ($request->filled('email')) {
    //         $user->email = $request->email;
    //     }

    //     if ($request->filled('password')) {
    //         $user->password = bcrypt($request->password);
    //     }

    //     if ($request->filled('cpf')) {
    //         $user->cpf = $request->cpf;
    //     }

    //     if ($request->filled('birth_date')) {
    //         $user->birth_date = $request->birth_date;
    //     }

    //     return $user;
    // }

    private function convertToCreate(UserRequest $request): User
    {
        $address = new Address([
            'cep' => $request->address['cep'],
            'state' => $request->address['state'],
            'city' => $request->address['city'],
            'neighborhood' => $request->address['neighborhood'],
            'street' => $request->address['street'],
            'number' => $request->address['number'],
            'complement' => $request->address['complement'],
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'cpf' => $request->cpf,
            'birth_date' => $request->birth_date,
            'registration_date' => $request->registration_date,
        ]);

        $user->setRelation('address', $address);

        return $user;
    }
}


// "name": "manager7",
//         "email": "manager8@gmail.com",
//         "password": "manager",
//         "cpf": "123.456.789-13",
//         "birth_date": "1990-01-02",
//         "registration_date": "2024-05-13",
//         "address": {
//             "cep": "12345-678",
//             "state": "SP",
//             "city": "São Paulo",
//             "neighborhood": "Centro",
//             "street": "Rua das Flores",
//             "number": "123",
//             "complement": "Apto 45"
//         }