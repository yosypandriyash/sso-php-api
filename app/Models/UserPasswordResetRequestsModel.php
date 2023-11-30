<?php

namespace App\Models;

use App\Models\Base\UserPasswordResetRequestsBaseModel;
use App\Persistence\MySql\MySqlDefinitions;


class UserPasswordResetRequestsModel extends UserPasswordResetRequestsBaseModel {

    protected function getByUniqueId(string $uniqueId): ?UserPasswordResetRequestsModel
    {
        return $this->getFirst([
            'uniqueId' => $uniqueId
        ]);
    }

    protected function getOneActiveByUserId(string $userId): ?UserPasswordResetRequestsModel
    {
        $currentDateTime = (new \DateTime())->format(MySqlDefinitions::DATE_FORMAT);

        return $this->getFirst([
            'userId' => $userId,
            'isActive' => true,
            'expiration_date >' => $currentDateTime
        ]);
    }
}
