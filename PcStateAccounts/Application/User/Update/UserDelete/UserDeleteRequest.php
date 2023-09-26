<?php

namespace Core\Application\User\Update\UserDelete;

use Core\Application\ApplicationRequestInterface;

class UserDeleteRequest implements ApplicationRequestInterface {

    private string $userUniqueId;


    private function __construct(
        string $userUniqueId
    ) {
        $this->userUniqueId = $userUniqueId;
    }

    public static function create(
        string $userUniqueId
    ): self
    {
        return new static ($userUniqueId);
    }

    public function getUserUniqueId(): string
    {
        return $this->userUniqueId;
    }
}