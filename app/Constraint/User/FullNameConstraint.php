<?php

namespace App\Constraint\User;

use App\Constraint\BaseConstraint;

class FullNameConstraint extends BaseConstraint {

    protected string $exceptionMessage = 'Invalid full name';

    private const VALIDATION_REGEX = '/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.-]+$/';

    public function validateField($param = null): bool
    {
        return preg_match(self::VALIDATION_REGEX, $param);
    }
}