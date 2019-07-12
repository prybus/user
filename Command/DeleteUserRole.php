<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

use MsgPhp\User\UserId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class DeleteUserRole
{
    public $userId;
    public $roleName;

    public function __construct(UserId $userId, string $roleName)
    {
        $this->userId = $userId;
        $this->roleName = $roleName;
    }
}
