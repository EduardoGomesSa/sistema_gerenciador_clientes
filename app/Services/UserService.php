<?php

namespace App\Services;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserGetByIdRequest;
use App\Http\Requests\UserGetNameRequest;
use App\Http\Requests\UserGetRegistrationDateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getById(UserGetByIdRequest $request)
    {
        $userAuthenticated = auth()->user();

        if($userAuthenticated->role == 'customer'){
            if($userAuthenticated->id != $request['id']){
                $user =  $this->repository->getById($userAuthenticated->id);
            }
        } else {
            $user =  $this->repository->getById($request->id);
        }
        
        if(!$user) return null;

        return new CustomerResource($user);
    }

    public function getByName(UserGetNameRequest $request)
    {
        return CustomerResource::collection(
            $this->repository->getByName($request['name'])
        );
    }

    public function getByRegistrationDate(UserGetRegistrationDateRequest $request)
    {
        return CustomerResource::collection(
            $this->repository->getByRegistrationDate($request->registration_date)
        );
    }

    public function store(UserRequest $request)
    {
        $user = $this->convertToCreate($request);

        $userCreated = $this->repository->store($user);

        if (!$userCreated) return null;

        $resource = new UserResource($userCreated);

        return $resource;
    }

    public function update(UserUpdateRequest $request)
    {
        $userAuthenticated = auth()->user();

        if($userAuthenticated->role == 'customer'){
            if($userAuthenticated->id != $request['id']){
                $user = $userAuthenticated;
            }
        } else {
            $userExist = $this->repository->userExistById($request['id']);

            if (!$userExist) return false;

            $user = $this->repository->getById($request['id']);
        }

        $userToUpdate = $this->convertToUpdate($request, $user);

        $userUpdated = $this->repository->update($userToUpdate);

        return $userUpdated;
    }

    public function destroy(UserDeleteRequest $request)
    {
        $userExist = $this->repository->userExistById($request['id']);

        if (!$userExist) return false;

        $userDeleted = $this->repository->destroy($request['id']);

        return $userDeleted;
    }

    private function convertToUpdate(UserUpdateRequest $request, User $user) : User{
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->filled('cpf')) {
            $user->cpf = $request->cpf;
        }

        if ($request->filled('birth_date')) {
            $user->birth_date = $request->birth_date;
        }

        if ($request->filled('path_photo')) {
            $this->photoDelete(strval($user->path_photo));

            $user->path_photo = $this->photoPath($request);
        }

        return $user;
    }

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
            'path_photo' => $this->photoPath($request),
        ]);

        $user->setRelation('address', $address);

        return $user;
    }

    private function photoPath($request) {
        if(!$request->path_photo) return null;

        $image = $request->file('path_photo');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);

        $imagePath = 'images/'.$imageName;

        return $imagePath;
    }

    private function photoDelete(string $path){
        if(file_exists($path)){
            unlink($path);
        }
    }
}