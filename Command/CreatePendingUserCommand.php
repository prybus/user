<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreatePendingUserCommand
{
    public $email;
    public $password;
    public $plainPassword;
    public $context;

    public function __construct(string $email, string $password, bool $plainPassword = true, array $context = [])
    {
        $this->email = $email;
        $this->password = $password;
        $this->plainPassword = $plainPassword;
        $this->context = $context;
    }
}
