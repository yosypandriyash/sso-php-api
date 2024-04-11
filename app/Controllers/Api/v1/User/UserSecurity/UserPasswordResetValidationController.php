<?php

namespace App\Controllers\Api\v1\User\UserSecurity;

use App\Constraint\User\UserPasswordResetTokenConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Controllers\Api\v1\User\UserApiController;
use App\Persistence\MySql\MySqlDefinitions;
use App\Persistence\MySql\User\MySqlUserPasswordResetRequestRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\PasswordReset\Validation\UserPasswordResetValidationRequest;
use Core\Application\User\PasswordReset\Validation\UserPasswordResetValidationService;

class UserPasswordResetValidationController extends UserApiController
{
    protected array $requestParameters = [
        'passwordResetToken' => UserPasswordResetTokenConstraint::class,
    ];

    // http://pcstate-accounts.web.local/api/v1/users/reset-password/confirm/b0nhS3b0ncTwhS3hS3cTwfF1gS1b0nea956euq7ZkwfCJrMzmP8S12QxOKDHlAVI4YEcsdp6bWRi03FTB5vL9GanXNhyogUt
    public function index($passwordResetToken): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters(
            ['passwordResetToken' => $passwordResetToken]
        );

        try {

            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $applicationServiceResponse = (new UserPasswordResetValidationService(
                new MySqlUserPasswordResetRequestRepository(),
            ))->execute(
                UserPasswordResetValidationRequest::create(
                    $this->request->getIPAddress(),
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
            $success ? 'PASSWORD_RESET_REQUEST_VALIDATION_SUCCESS' : 'PASSWORD_RESET_REQUEST_VALIDATION_ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }

}
