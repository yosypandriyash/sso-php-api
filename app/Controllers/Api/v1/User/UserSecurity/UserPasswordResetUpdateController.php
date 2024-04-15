<?php

namespace App\Controllers\Api\v1\User\UserSecurity;

use App\Constraint\User\PasswordConstraint;
use App\Constraint\User\UserPasswordResetTokenConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Controllers\Api\v1\User\UserApiController;
use App\Persistence\MySql\User\MySqlUserPasswordResetRequestRepository;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\PasswordReset\Update\UserPasswordResetUpdateRequest;
use Core\Application\User\PasswordReset\Update\UserPasswordResetUpdateService;

class UserPasswordResetUpdateController extends UserApiController
{
    protected array $requestParameters = [
        'newPassword' => PasswordConstraint::class,
        'passwordResetToken' => UserPasswordResetTokenConstraint::class,
    ];

    public function index($passwordResetToken): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters(
            ['passwordResetToken' => $passwordResetToken]
        );

        try {

            $validationResult = $this->validateFields(
                $bodyParams,
                $this->requestParameters
            );

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new UserPasswordResetUpdateService(
                new MySqlUserRepository(),
                new MySqlUserPasswordResetRequestRepository(),
            ))->execute(
                UserPasswordResetUpdateRequest::create(
                    $this->request->getIPAddress(),
                    $bodyParams['newPassword'],
                    $passwordResetToken
                )
            );

            $result = $applicationServiceResponse->getResult();
            $success = $applicationServiceResponse->isSuccess();
            $error = $applicationServiceResponse->getErrorMessage();

        } catch (\Exception $exception) {

            $result = [];
            $success = false;
            $error = $exception->getMessage();
        }

        $apiResponse = new XhrResponse();
        $apiResponse->setOperationStatus(
            $success ? 'PASSWORD_UPDATED_SUCCESS' : 'PASSWORD_UPDATE_FAILED',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }

}
