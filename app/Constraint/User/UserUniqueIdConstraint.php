<?php

namespace App\Constraint\User;

use App\Constraint\Misc\UniqueIdConstraint;

class UserUniqueIdConstraint extends UniqueIdConstraint {

    protected string $exceptionMessage = 'invalid user unique id token';

}