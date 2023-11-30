<?php

namespace Core\Domain\User\Infrastructure;

use Core\Domain\User\User;
use Core\Domain\User\UserPasswordResetRequest;

interface UserPasswordResetRequestRepositoryInterface {

    public function getOneByUniqueId(string $uniqueId): ?UserPasswordResetRequest;

    public function saveEntity(UserPasswordResetRequest $userPasswordResetRequest): UserPasswordResetRequest;

    public function getOneActiveByUser(User $user): ?UserPasswordResetRequest;

}