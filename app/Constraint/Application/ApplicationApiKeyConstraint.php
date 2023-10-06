<?php

namespace App\Constraint\Application;

use App\Constraint\BaseConstraint;

class ApplicationApiKeyConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'invalid application api key';

    private const VALIDATION_REGEX = '/^[a-zA-Z0-9]{96}$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}