<?php

namespace Core\Domain\Application\Infrastructure;

use Core\Domain\Application\Application;

interface ApplicationRepositoryInterface {

    public function getApplicationByName(string $applicationUniqueName): ?Application;

    public function getApplicationByUniqueId(string $applicationUniqueId): ?Application;

    public function saveEntity(Application $application): Application;

    public function validateApplicationRequest(string $applicationUniqueId, string $applicationApiKey): bool;
}