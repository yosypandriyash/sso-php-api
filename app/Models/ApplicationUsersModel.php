<?php

namespace App\Models;

use App\Models\Base\ApplicationUsersBaseModel;



class ApplicationUsersModel extends ApplicationUsersBaseModel {

    public function getApplicationUsersCountFilteredByAppIdEmail(string $applicationUniqueId, string $userEmail): int
    {
        $items = $this->query(
            '
                SELECT 
                   count(id) as result
                FROM application_users
                WHERE
                    application_id = (select id from applications where unique_id =  "' . $applicationUniqueId .  '")
                AND
                    user_id = (select id from users where email =  "' . $userEmail .  '")', false);

        $items = reset($items);
        return (int) $items['result'];
    }

    public function getApplicationUserCount(string $applicationUniqueId, string $userUniqueId): int
    {
        $items = $this->query(
            '
                SELECT 
                   count(id) as result
                FROM application_users
                WHERE
                    application_id = (select id from applications where unique_id = "' . $applicationUniqueId . '" )  
                AND 
                    user_id = (select id from users where unique_id = "' . $userUniqueId . '")'
            ,false);

        $items = reset($items);
        return (int) $items['result'];
    }

}
