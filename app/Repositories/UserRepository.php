<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function userExistById($id): bool
    {
        return $this->user->find($id) != null;

        return false;
    }

    public function userExistByCpf($cpf): bool
    {
        return $this->user->where('cpf', $cpf)->first() != null;

        return false;
    }

    public function getById($id)
    {
        return $this->user->find($id);
    }

    public function store(User $user): User
    {
        $userCreated = $this->user->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'cpf' => $user->cpf,
            'birth_date' => $user->birth_date,
            'registration_date' => $user->registration_date,
        ]);

        if (!$userCreated) return null;

        $userCreated->address()->save($user->address);

        return $userCreated;
    }

    public function update(User $user) : bool {
        $userUpdated = $user->save();

        if($userUpdated) return true;

        return false;
    }
}
