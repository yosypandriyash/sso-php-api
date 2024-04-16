<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Frontend-routes
$routes->get('/auth/login', 'User\Authentication\UserAuthenticationViewController::userLoginView');
$routes->get('/auth/register', 'User\Authentication\UserAuthenticationViewController::userRegistrationView');
$routes->get('/auth/password-reset', 'User\Authentication\UserAuthenticationViewController::userRegistrationView');

// API Routes: (apiKey required)

/* User */
$routes->post('/api/v1/users/create', 'Api\v1\User\UserRegistrationController::index/$1');
$routes->post('/api/v1/users/validate', 'Api\v1\User\UserValidationController::index/$1');
$routes->post('/api/v1/users/(:alphanum)/update', 'Api\v1\User\UserUpdateController::index/$1');
$routes->post('/api/v1/users/(:alphanum)/delete', 'Api\v1\User\UserDeleteController::index/$1');

/* User reset-password*/
$routes->post('/api/v1/users/reset-password/request', 'Api\v1\User\UserSecurity\UserPasswordResetRequestController::index/$1');
$routes->post('/api/v1/users/reset-password/(:alphanum)/update', 'Api\v1\User\UserSecurity\UserPasswordResetUpdateController::index/$1');
$routes->get('/api/v1/users/reset-password/confirm/(:alphanum)', 'Api\v1\User\UserSecurity\UserPasswordResetValidationController::index/$1', [
    'as' => 'user_password_reset_validation'
]);


/* User permission */
$routes->get('/api/v1/users/(:alphanum)/permissions/list', 'Api\v1\UserPermission\ListPermissionGrantedToUserController::index/$1');
$routes->post('/api/v1/users/(:alphanum)/permissions/grant/(:alphanum)', 'Api\v1\UserPermission\GrantPermissionToUserController::index/$1/$2');
$routes->post('/api/v1/users/(:alphanum)/permissions/revoke/(:alphanum)', 'Api\v1\UserPermission\RevokePermissionFromUserController::index/$1/$2');

$routes->post('/api/v1/applications/create', 'Api\v1\Application\ApplicationRegistrationController::index');
// update-application
// delete-application

/* Application permissions */
// application-permissions list
// application-permission update
$routes->get('/api/v1/applications/(:alphanum)/permissions/list', 'Api\v1\ApplicationPermission\ApplicationPermissionListController::index/$1');
$routes->post('/api/v1/applications/(:alphanum)/permissions/create', 'Api\v1\ApplicationPermission\ApplicationPermissionRegistrationController::index/$1');
$routes->post('/api/v1/applications/(:alphanum)/permissions/(:alphanum)/delete', 'Api\v1\ApplicationPermission\ApplicationPermissionDeleteController::index/$1/$2');

/* Application user permissions */
$routes->get('/api/v1/users/(:alphanum)/application/(:alphanum)/permissions/list', 'Api\v1\UserApplicationPermission\ListApplicationPermissionGrantedToUserController::index/$1/$2');


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
