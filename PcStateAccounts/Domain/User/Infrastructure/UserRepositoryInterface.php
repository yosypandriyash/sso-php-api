<?php

namespace Core\Domain\User\Infrastructure;

use Core\Domain\User\User;

interface UserRepositoryInterface {

    public function getOneByUserNameAndEmail($userName, $email): ?User;

    public function saveEntity(User $user): User;

}