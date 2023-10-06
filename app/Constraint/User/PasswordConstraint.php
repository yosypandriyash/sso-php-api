<?php

namespace App\Constraint\User;

use App\Constraint\BaseConstraint;

class PasswordConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid password';

    public function validateField($param = null): bool
    {
        return strlen(trim($param)) > 8;
    }
}