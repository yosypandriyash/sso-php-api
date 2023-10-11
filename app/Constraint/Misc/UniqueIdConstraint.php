<?php

namespace App\Constraint\Misc;

use App\Constraint\BaseConstraint;

class UniqueIdConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid unique id token';

    private const VALIDATION_REGEX = '/^[a-zA-Z0-9]{96}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}