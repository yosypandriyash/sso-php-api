<?php

namespace App\Constraint;

class PasswordConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid password';

    public function validateField($param = null): bool
    {
        return strlen(trim($param)) > 8;
    }
}