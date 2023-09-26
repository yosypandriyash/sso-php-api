<?php

namespace Core\Domain\User\Infrastructure;

use Core\Domain\User\User;

interface UserRepositoryInterface {

    public function getOneByUniqueId(string $userUniqueId): ?User;

    public function getOneByEmail( string $email): ?User;

    public function getOneByUserName(string $userName): ?User;

    public function getOneByEmailAndPassword(string $email, string $password): ?User;

    public function saveEntity(User $user): User;

}