<?php

namespace App\Constraint\Application;

use App\Constraint\BaseConstraint;

class CallbackUrlConstraint extends UrlConstraint {

    protected string $exceptionMessage = 'Invalid callback-url. Must be full url';

}