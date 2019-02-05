<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\User\Entity\Fields;

use MsgPhp\User\Entity\Role;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait RoleField
{
    /**
     * @var Role
     */
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
