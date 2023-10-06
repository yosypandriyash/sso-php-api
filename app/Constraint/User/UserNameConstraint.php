<?php

namespace App\Constraint\User;

use App\Constraint\BaseConstraint;

class UserNameConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid username';

    private const VALIDATION_REGEX = '/^(?=.{5,64}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}