<?php

namespace App\Constraint;

abstract class BaseConstraint implements Constraint {

    protected string $exceptionMessage = 'Validation error';

    public function getExceptionMessage(): string
    {
        return $this->exceptionMessage;
    }
}