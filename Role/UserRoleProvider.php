<?php

declare(strict_types=1);

namespace MsgPhp\User\Role;

use MsgPhp\User\Repository\UserRoleRepository;
use MsgPhp\User\User;
use MsgPhp\User\UserRole;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserRoleProvider implements RoleProvider
{
    private $repository;

    public function __construct(UserRoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRoles(User $user): array
    {
        $roles = $this->repository->findAllByUserId($user->getId())->map(static function (UserRole $userRole): string {
            return $userRole->getRoleName();
        });

        return iterator_to_array($roles, false);
    }
}
