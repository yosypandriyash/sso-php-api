<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */


$routes->post('/api/v1/users/create-user', 'Api\v1\User\UserRegistrationController::index/$1');
$routes->post('/api/v1/users/(:alphanum)/update', 'Api\v1\User\UserUpdateController::index/$1');
$routes->post('/api/v1/users/(:alphanum)/delete', 'Api\v1\User\UserDeleteController::index/$1');
$routes->post('/api/v1/users/(:alphanum)/grant-permission/(:alphanum)', 'Api\v1\User\UserAddPermissionController::index/$1/$2');
$routes->post('/api/v1/users/(:alphanum)/revoke-permission/(:alphanum)', 'Api\v1\User\UserRemovePermissionController::index/$1/$2');
$routes->post('/api/v1/users/validate', 'Api\v1\User\UserValidationController::index/$1');

//$routes->add('/api/v1/(:alphanum)/logout-user', 'Api\v1\User\UserRegistrationController::index/$1');
//$routes->add('/api/v1/(:alphanum)/reset-password-user', 'Api\v1\User\UserRegistrationController::index/$1');

$routes->post('/api/v1/applications/create-application', 'Api\v1\Application\ApplicationRegistrationController::index');

$routes->post('/api/v1/applications/(:alphanum)/add-permission', 'Api\v1\ApplicationPermission\ApplicationPermissionRegistrationController::index/$1');
$routes->post('/api/v1/applications/(:alphanum)/remove-permission/(:alphanum)', 'Api\v1\ApplicationPermission\ApplicationPermissionDeleteController::index/$1/$2');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
