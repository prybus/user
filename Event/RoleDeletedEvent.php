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

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\Role;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class RoleDeletedEvent
{
    /**
     * @var Role
     */
    public $role;

    final public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
