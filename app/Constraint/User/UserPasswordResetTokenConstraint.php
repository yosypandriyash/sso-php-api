<?php

namespace App\Constraint\User;

use App\Constraint\BaseConstraint;

class UserPasswordResetTokenConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid password-reset token format';

    private const VALIDATION_REGEX = '/^[a-zA-Z0-9]{96}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}