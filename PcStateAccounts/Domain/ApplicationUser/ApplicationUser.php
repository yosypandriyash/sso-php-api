<?php

namespace Core\Domain\ApplicationUser;

use Core\Domain\Application\Application;
use Core\Domain\DomainModel;
use Core\Domain\User\User;
use Core\Domain\ValueObjects\PrimaryKey;

class ApplicationUser extends DomainModel {

    public const MAXIMUM_ALLOWED_DUPLICATED_APPLICATION_USERS = 0;

    private string $uniqueId;
    private Application $application;
    private User $user;

    private function __construct(
        ?PrimaryKey $id,
        string $uniqueId,
        Application $application,
        User $user
    ) {
        $this->id = $id;
        $this->uniqueId = $uniqueId;
        $this->application = $application;
        $this->user = $user;
    }

    public static function create(
        ?string $id,
        string $uniqueId,
        Application $application,
        User $user
    ): self {

        return new self(
            self::parsePrimaryKeyType($id),
            $uniqueId,
            $application,
            $user
        );
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): void
    {
        $this->uniqueId = $uniqueId;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return [
            'uniqueId' => $this->uniqueId,
            'application' => $this->application->toArray(),
            'user' => $this->user->toArray(),
        ];
    }
}