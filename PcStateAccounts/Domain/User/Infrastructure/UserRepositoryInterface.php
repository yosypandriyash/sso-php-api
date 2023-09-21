<?php

namespace Core\Domain\User\Infrastructure;

use Core\Domain\User\User;

interface UserRepositoryInterface {

    public function getOneByUserNameAndEmail(string $userName,string $email): ?User;

    public function getOneByEmailAndPassword(string $email, string $password): ?User;

    public function saveEntity(User $user): User;

}