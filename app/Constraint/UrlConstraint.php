<?php

namespace App\Constraint;

class UrlConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'Invalid url';

    public function validateField($param = null): bool
    {
        return filter_var($param, FILTER_VALIDATE_URL);
    }
}