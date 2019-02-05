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

namespace MsgPhp\User\Role;

use MsgPhp\User\Entity\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DefaultRoleProvider implements RoleProviderInterface
{
    /**
     * @var string[]
     */
    private $roles;

    /**
     * @param string[] $roles
     */
    public function __construct(array $roles, bool $sanitize = true)
    {
        $this->roles = $sanitize ? array_values(array_unique($roles)) : $roles;
    }

    public function getRoles(User $user): array
    {
        return $this->roles;
    }
}
