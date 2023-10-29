<?php

namespace App\Controllers\User\Authentication;

use App\Controllers\ViewController;

class UserAuthenticationViewController extends ViewController {

    /**
     * @return string
     */
    public function userLoginView(): string
    {
        $this->setPage('Pages/Default/Auth/login.view.php');
        return $this->view();
    }

    /**
     * @return string
     */
    public function userRegistrationView(): string
    {
        $this->setPage('Pages/Default/Auth/register.view.php');
        return $this->view();
    }

    /**
     * @return string
     */
    public function userForgottenPasswordView(): string
    {
        $this->setPage('Pages/Default/Auth/reset-password.view.php');
        return $this->view();
    }
}