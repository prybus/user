<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\UserRole;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserRoleAdded
{
    public $userRole;
    public $context;

    public function __construct(UserRole $userRole, array $context)
    {
        $this->userRole = $userRole;
        $this->context = $context;
    }
}
