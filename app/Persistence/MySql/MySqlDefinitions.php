<?php

namespace App\Persistence\MySql;

use App\Models\ApplicationsModel;
use App\Models\ApplicationUsersModel;
use App\Models\Base\BaseModel;
use App\Models\UsersModel;
use Core\Domain\Application\Application;
use Core\Domain\ApplicationUser\ApplicationUser;
use Core\Domain\User\User;

final class MySqlDefinitions {

    public const DATE_FORMAT = 'Y-m-d H:i:s';
}