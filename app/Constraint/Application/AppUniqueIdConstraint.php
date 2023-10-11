<?php

namespace App\Constraint\Application;

use App\Constraint\Misc\UniqueIdConstraint;

class AppUniqueIdConstraint extends UniqueIdConstraint {

    protected string $exceptionMessage = 'invalid app unique id token';

}