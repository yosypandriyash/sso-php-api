<?php

namespace App\Persistence\MySql\Application;

use App\Models\ApplicationsModel;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\Application\Application;
use Core\Domain\Application\Exception\CouldNotSaveApplicationException;
use Core\Domain\Application\Infrastructure\ApplicationRepositoryInterface;

class MySqlApplicationRepository extends ApplicationsModel implements ApplicationRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function getApplicationByName(string $applicationUniqueName): ?Application
    {
        /** @var ApplicationsModel $application */
        $application = $this->getOneByKey('appName', $applicationUniqueName);
        if (!$application) {
            return null;
        }

        return MySqlModelToDomainEntityTransformer::execute(ApplicationsModel::class, $application);
    }

    public function validateApplicationRequest(string $applicationUniqueId, string $applicationApiKey): bool
    {
        $application = $this->getFirst([
            'uniqueId' => $applicationUniqueId,
            'apiKey' => $applicationApiKey
        ]);

        return $application instanceof ApplicationsModel;
    }

    /**
     * @param string $applicationUniqueId
     * @return Application|null
     * @throws \Exception
     */
    public function getApplicationByUniqueId(string $applicationUniqueId): ?Application
    {
        /** @var ApplicationsModel $application */
        $application = parent::getOneByKey('uniqueId', $applicationUniqueId);
        if (!$application) {
            return null;
        }

        return MySqlModelToDomainEntityTransformer::execute(ApplicationsModel::class, $application);
    }

    /**
     * @throws CouldNotSaveApplicationException
     */
    public function saveEntity(Application $application): Application
    {
        $applicationModel = new ApplicationsModel();
        $applicationModel->setUniqueId($application->getUniqueId());
        $applicationModel->setApiKey($application->getApiKey());
        $applicationModel->setAppName($application->getApplicationName());
        $applicationModel->setUrl($application->getUrl());
        $applicationModel->setCallbackUrl($application->getCallbackUrl());

        try {
            if (!$applicationModel->save()) {
                throw new \Exception();
            }

            $application->setId($applicationModel->getLastInsertionId());

        } catch (\Exception $exception) {
            throw new CouldNotSaveApplicationException();
        }

        return $application;
    }
}