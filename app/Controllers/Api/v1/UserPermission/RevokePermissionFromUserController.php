<?php

namespace App\Controllers\Api\v1\UserPermission;

use App\Constraint\Permission\PermissionUniqueIdConstraint;
use App\Constraint\User\UserUniqueIdConstraint;
use CodeIgniter\HTTP\ResponseInterface;

class RevokePermissionFromUserController extends UserPermissionApiController {

    protected array $requestParameters = [
        'userUniqueId' => UserUniqueIdConstraint::class,
        'permissionUniqueId' => PermissionUniqueIdConstraint::class
    ];

    public function index($userUniqueId, $permissionUniqueId): ResponseInterface
    {

    }
}