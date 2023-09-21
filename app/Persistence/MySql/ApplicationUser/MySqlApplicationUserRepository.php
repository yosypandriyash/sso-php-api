<?php

namespace App\Persistence\MySql\ApplicationUser;

use App\Models\ApplicationsModel;
use App\Models\ApplicationUsersModel;
use App\Models\UsersModel;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\ApplicationUser\ApplicationUser;
use Core\Domain\ApplicationUser\Exception\CouldNotSaveApplicationUserException;
use Core\Domain\ApplicationUser\Infrastructure\ApplicationUserRepositoryInterface;
use Exception;

class MySqlApplicationUserRepository extends ApplicationUsersModel implements ApplicationUserRepositoryInterface
{
    public function getApplicationUsersCountFilteredByAppIdEmail(string $applicationUniqueId, string $userEmail): int
    {
        return parent::getApplicationUsersCountFilteredByAppIdEmail($applicationUniqueId, $userEmail);
    }

    public function getApplicationUserCount(int $applicationId, int $userId): int
    {
        return parent::getApplicationUserCount($applicationId, $userId);
    }

    /**
     * @throws Exception
     */
    public function getAllByUserUniqueFields(string $userEmail, string $userName, string $applicationUniqueId): array
    {
        $applicationUserModelResult = $this->getAllWithDependencies(
            [
                'application.uniqueId' => [$applicationUniqueId],
                'user.email' => [$userEmail],
                'user.userName' => [$userName]
            ],
            [
                'applicationUser' => ApplicationUsersModel::class,
                'application' => ApplicationsModel::class,
                'user' => UsersModel::class
            ]
        );

        return $this->constructApplicationUsersJoinedResponse($applicationUserModelResult);
    }

    /**
     * @param array $modelData
     * @return array
     * @throws Exception
     */
    private function constructApplicationUsersJoinedResponse(array $modelData): array
    {
        $response = [];
        foreach ($modelData as $resultLine) {
            $user = MySqlModelToDomainEntityTransformer::execute(UsersModel::class, $resultLine['user']);
            $application = MySqlModelToDomainEntityTransformer::execute(ApplicationsModel::class, $resultLine['application']);

            /** @var ApplicationUsersModel $applicationUser */
            $applicationUser = $resultLine['applicationUser'];

            $response[] = ApplicationUser::create(
                $applicationUser->getId(),
                $applicationUser->getUniqueId(),
                $application,
                $user
            );
        }

        return $response;
    }

    /**
     * @throws CouldNotSaveApplicationUserException
     */
    public function saveEntity(ApplicationUser $applicationUser): ApplicationUser
    {
        $applicationUserModel = new ApplicationUsersModel();
        $applicationUserModel->setUniqueId($applicationUser->getUniqueId());
        $applicationUserModel->setApplicationId($applicationUser->getApplication()->getId()->getValue());
        $applicationUserModel->setUserId($applicationUser->getUser()->getId()->getValue());

        try {
            if (!$applicationUserModel->save()) {
                throw new Exception();
            }

            $applicationUser->setId($applicationUserModel->getLastInsertionId());

        } catch (Exception $exception) {
            throw new CouldNotSaveApplicationUserException();
        }

        return $applicationUser;
    }
}