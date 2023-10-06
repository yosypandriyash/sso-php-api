<?php

namespace App\Constraint\Permission;

use App\Constraint\BaseConstraint;

class PermissionIsActiveConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid permission active status';

    private const VALIDATION_REGEX = '/^(0|1)$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}