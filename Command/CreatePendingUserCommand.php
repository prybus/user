<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreatePendingUserCommand
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var bool */
    public $plainPassword;

    public function __construct(string $email, string $password, bool $plainPassword = true)
    {
        $this->email = $email;
        $this->password = $password;
        $this->plainPassword = $plainPassword;
    }
}
