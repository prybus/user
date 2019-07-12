<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Role;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class RoleCreated
{
    public $role;
    public $context;

    public function __construct(Role $role, array $context)
    {
        $this->role = $role;
        $this->context = $context;
    }
}
