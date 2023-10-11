<?php

namespace Core\Domain\ApplicationUser\Infrastructure;

use Core\Domain\ApplicationUser\ApplicationUser;

interface ApplicationUserRepositoryInterface {

    public function getApplicationUsersCountFilteredByAppIdEmail(string $applicationUniqueId, string $userEmail): int;

    public function getAllByUserUniqueFields(string $userEmail, string $userName, string $applicationUniqueId): array;

    public function getApplicationUserCount(string $applicationUniqueId, string $userUniqueId): int;

    public function saveEntity(ApplicationUser $applicationUser): ApplicationUser;

}