<?php

namespace Core\Application\Notification\Template;

class ResetPasswordRequestNotification extends AbstractNotification {

    protected ?int $priority = 1;
    protected ?string $subject = 'Restablecimiento de clave';

    protected ?string $message = '
    <h1>Acceda al siguiente enlace para cambiar la contraseña de su cuenta</h1>
    <br>
    <a href="<:passwordResetUrl:>"><:passwordResetUrl:></a>';

}