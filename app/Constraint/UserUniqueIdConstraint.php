<?php

namespace App\Constraint;

class UserUniqueIdConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid user unique id token';

    private const VALIDATION_REGEX = '/^[a-zA-Z0-9]{96}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}