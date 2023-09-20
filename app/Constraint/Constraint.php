<?php

namespace App\Constraint;

interface Constraint {

    public function validateField($param = null): bool;

    public function getExceptionMessage(): string;
}