<?php

namespace App\Constraint\Permission;

use App\Constraint\BaseConstraint;

class PermissionDescriptionConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid permission description';

    private const VALIDATION_REGEX = '/^(.){0,128}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}