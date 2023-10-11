<?php

namespace App\Constraint\Permission;

use App\Constraint\Misc\UniqueIdConstraint;

class PermissionUniqueIdConstraint extends UniqueIdConstraint {

    protected string $exceptionMessage = 'invalid permission id';

}