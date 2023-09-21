<?php

namespace App\Persistence\MySql\User;

use App\Models\UsersModel;
use App\Persistence\MySql\MySqlModelToDomainEntityTransformer;
use Core\Domain\User\Exception\CouldNotSaveUserException;
use Core\Domain\User\Infrastructure\UserRepositoryInterface;
use Core\Domain\User\User;
use Exception;

class MySqlUserRepository extends UsersModel implements UserRepositoryInterface
{

    /**
     * @throws CouldNotSaveUserException
     */
    public function saveEntity(User $user): User
    {
        $userModel = new UsersModel();
        $userModel->setUniqueId($user->getUniqueId());
        $userModel->setUsername($user->getUsername());
        $userModel->setFullName($user->getFullName());
        $userModel->setEmail($user->getEmail());
        $userModel->setPassword($user->getPassword());

        try {
            if (!$userModel->save()) {
                throw new Exception();
            }

            $user->setId($userModel->getLastInsertionId());

        } catch (Exception $exception) {
            throw new CouldNotSaveUserException();
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

    /**
     * @param string $userName
     * @param string $email
     * @return User|null
     * @throws Exception
     */
    public function getOneByUserNameAndEmail(string $userName,string $email): ?User
    {
        $userModel = $this->getFirst([
            'userName' => $userName,
            'email' => $email
        ]);

        return $userModel !== null ? MySqlModelToDomainEntityTransformer::execute(UsersModel::class, $userModel): null;
    }
}