<?php

namespace App\Controllers\Api\v1\User\UserSecurity;

use App\Constraint\User\EmailConstraint;
use App\Controllers\Api\v1\Response\XhrResponse;
use App\Controllers\Api\v1\User\UserApiController;
use App\Helpers\StringHelper;
use App\Notification\Mail\MailNotificationSender;
use App\Persistence\MySql\Application\MySqlApplicationRepository;
use App\Persistence\MySql\User\MySqlUserPasswordResetRequestRepository;
use App\Persistence\MySql\User\MySqlUserRepository;
use CodeIgniter\HTTP\ResponseInterface;
use Core\Application\User\PasswordReset\Request\UserPasswordResetRequestRequest;
use Core\Application\User\PasswordReset\Request\UserPasswordResetRequestService;

class UserPasswordResetRequestController extends UserApiController
{
    private const PASSWORD_RESET_CALLBACK_URL = 'user_password_reset_validation';

    protected array $requestParameters = [
        'email' => EmailConstraint::class,
    ];

    public function index(): ResponseInterface
    {
        $bodyParams = $this->retrieveBodyRequestParameters();

        try {

            $validationResult = $this->validateFields($bodyParams, $this->requestParameters);

            if (!$validationResult->isValidationSuccess()) {
                return $this->constraintViolationResponse($validationResult);
            }

            $passwordResetPlaceholder = 'passwordResetUniqueId';
            $passwordResetUrl = $this->cleanUrl(
                url_to(self::PASSWORD_RESET_CALLBACK_URL, $passwordResetPlaceholder)
            );

            $applicationServiceResponse = (new UserPasswordResetRequestService(
                new MySqlUserRepository(),
                new MySqlUserPasswordResetRequestRepository(),
                new MySqlApplicationRepository(),
                new MailNotificationSender(),
                new StringHelper()
            ))->execute(
                UserPasswordResetRequestRequest::create(
                    $bodyParams['email'],
                    $this->request->getIPAddress(),
                    $passwordResetUrl,
                    $passwordResetPlaceholder
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
            $success ? 'PASSWORD_RESET_REQUEST_SUCCESS' : 'PASSWORD_RESET_REQUEST_ERROR',
            $result
        );

        if ($error !== null) {
            $apiResponse->setServerException([$error]);
        }

        return $this->response($apiResponse);
    }
}