<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

use MsgPhp\User\UserId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ResetUserPassword
{
    public $userId;
    public $password;
    public $context;

    public function __construct(UserId $userId, string $password, array $context = [])
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->context = $context;
    }
}
