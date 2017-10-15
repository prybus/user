<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreateUserCommand
{
    /** @var UserIdInterface */
    public $userId;

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var bool */
    public $enable;

    /** @var bool */
    public $plainPassword;

    public function __construct(UserIdInterface $userId, string $email, string $password, bool $enable = false, bool $plainPassword = true)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
        $this->enable = $enable;
        $this->plainPassword = $plainPassword;
    }
}
