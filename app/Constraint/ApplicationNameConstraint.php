<?php

namespace App\Constraint;

class ApplicationNameConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'Invalid application name';

    private const VALIDATION_REGEX = '/^[a-zA-Z0-9.-\/]{4,32}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}