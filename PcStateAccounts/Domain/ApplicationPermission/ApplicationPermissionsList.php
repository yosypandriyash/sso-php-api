<?php

namespace Core\Domain\ApplicationPermission;

use Core\Domain\AbstractItemsList;

class ApplicationPermissionsList extends AbstractItemsList {

    public function toArray(): array
    {
        $result = [];

        foreach ($this->container as $applicationPermission) {

            /** @var ApplicationPermission $applicationPermission */
            $result[] = $applicationPermission;
        }

        return $result;
    }
}