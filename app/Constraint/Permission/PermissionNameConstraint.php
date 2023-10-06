<?php

namespace App\Constraint\Permission;

use App\Constraint\BaseConstraint;

class PermissionNameConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid permission name';

    private const VALIDATION_REGEX = '/^[a-zA-Z0-9.\-_\/]{5,64}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}