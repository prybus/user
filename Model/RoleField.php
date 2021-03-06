<?php

declare(strict_types=1);

namespace MsgPhp\User\Model;

use MsgPhp\User\Role;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait RoleField
{
    /** @var Role */
    private $role;

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getRoleName(): string
    {
        return $this->role->getName();
    }
}
