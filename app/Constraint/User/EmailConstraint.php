<?php

namespace App\Constraint\User;

use App\Constraint\BaseConstraint;

class EmailConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'Invalid email';

    public function validateField($param = null): bool
    {
        return filter_var($param, FILTER_VALIDATE_EMAIL);
    }
}