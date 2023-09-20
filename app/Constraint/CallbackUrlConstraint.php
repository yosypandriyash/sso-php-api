<?php

namespace App\Constraint;

class CallbackUrlConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'Invalid callback-url. Must be full url';

    public function validateField($param = null): bool
    {
        return filter_var($param, FILTER_VALIDATE_URL);
    }
}