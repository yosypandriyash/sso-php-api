<?php

namespace Core\Domain\ApplicationUser\Infrastructure;

use Core\Domain\ApplicationUser\ApplicationUser;

interface ApplicationUserRepositoryInterface {

    public function getAllByUserUniqueFields(string $userEmail, string $userName, string $applicationUniqueId): array;

    public function getApplicationUsersCount(string $applicationUniqueId, string $email): int;

    public function saveEntity(ApplicationUser $applicationUser): ApplicationUser;

}