<?php

namespace App\Persistence\MySql\User;

use App\Models\UsersModel;
use App\Persistence\Exception\CouldNotSaveException;
use App\Persistence\MySql\MySqlDefinitions;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\User;
use Exception;

class MySqlUserRepository extends UsersModel implements UserRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getOneByUniqueId(string $userUniqueId): ?User
    {
        $userModel = $this->getUserByUniqueId($userUniqueId);
        return $userModel !== null ? MySqlModelToDomainEntityTransformer::execute(UsersModel::class, $userModel): null;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function saveEntity(User $user): User
    {
        if ($user->getId() === null) {
            // Create
            $userModel = new UsersModel();
            $userModel->setUniqueId($user->getUniqueId());

        } else {
            // Update
            $userModel = $this->getUserByUniqueId($user->getUniqueId());
        }

        $userModel->setUsername($user->getUsername());
        $userModel->setFullName($user->getFullName());
        $userModel->setEmail($user->getEmail());
        $userModel->setPassword($user->getPassword());

        if ($user->getUpdatedAt() !== null) {
            $userModel->setUpdatedAt($user->getUpdatedAt()->format(MySqlDefinitions::DATE_FORMAT));
        }

        if ($user->isDeleted()) {
            $userModel->setDeletedAt($user->getDeletedAt()->format(MySqlDefinitions::DATE_FORMAT));
        }

        try {
            if (!$userModel->save()) {
                throw new Exception();
            }

            if ($user->getId() === null) {
                $user->setId($userModel->getLastInsertionId());
            }

        } catch (Exception $exception) {
            throw new CouldNotSaveException();
        }

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     * @throws Exception
     */
    public function getOneByEmailAndPassword(string $email, string $password): ?User
    {
        $userModel = $this->getFirst([
            'email' => $email,
            'password' => $password,
        ]);

        return $userModel !== null ? MySqlModelToDomainEntityTransformer::execute(UsersModel::class, $userModel): null;
    }

    public function getOneByEmail( string $email): ?User
    {
        $userModel = $this->getFirst([
            'email' => $email
        ]);

        return $userModel !== null ? MySqlModelToDomainEntityTransformer::execute(UsersModel::class, $userModel): null;
    }

    public function getOneByUserName(string $userName): ?User
    {
        $userModel = $this->getFirst([
            'userName' => $userName,
        ]);

        return $userModel !== null ? MySqlModelToDomainEntityTransformer::execute(UsersModel::class, $userModel): null;
    }

    private function getUserByUniqueId(string $uniqueId): ?UsersModel
    {
        return $this->getFirst([
            'uniqueId' => $uniqueId,
        ]);
    }
}