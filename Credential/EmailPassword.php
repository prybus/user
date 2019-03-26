<?php

declare(strict_types=1);

namespace MsgPhp\User\Credential;

use MsgPhp\User\Event\Domain\ChangeCredential;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class EmailPassword implements PasswordProtectedCredential
{
    use EmailAsUsername;
    use PasswordProtection;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function __invoke(ChangeCredential $event): bool
    {
        [
            'email' => $this->email,
            'password' => $this->password,
        ] = $event->fields + $vars = get_object_vars($this);

        return $vars !== get_object_vars($this);
    }
}
