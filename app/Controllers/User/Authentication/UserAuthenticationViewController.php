<?php

namespace App\Controllers\User\Authentication;

use App\Controllers\ViewController;

class UserAuthenticationViewController extends ViewController {

    /**
     * @return string
     */
    public function userLoginView(): string
    {
        $this->setPage('Pages/Default/Auth/login.php');
        return $this->view();
    }

    /**
     * @return string
     */
    public function userRegistrationView(): string
    {
        $this->setPage('Pages/Default/Auth/register.php');
        return $this->view();
    }

    /**
     * @return string
     */
    public function userForgottenPasswordView(): string
    {
        $this->setPage('Pages/Default/Auth/reset-password.php');
        return $this->view();
    }
}