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

namespace MsgPhp\User\Entity;

use MsgPhp\User\Entity\Fields\{RoleField, UserField};

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
abstract class UserRole
{
    use UserField;
    use RoleField;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
}
