<?php

declare(strict_types=1);

namespace MsgPhp\User\Role;

use MsgPhp\User\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DefaultRoleProvider implements RoleProvider
{
    /** @var array<int, string> */
    private $roles;

    /**
     * @param array<int, string> $roles
     */
    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles(User $user): array
    {
        return $this->roles;
    }
}
