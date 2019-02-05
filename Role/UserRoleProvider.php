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

use MsgPhp\User\Entity\{User, UserRole};
use MsgPhp\User\Repository\UserRoleRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserRoleProvider implements RoleProviderInterface
{
    /**
     * @var UserRoleRepositoryInterface
     */
    private $repository;

    public function __construct(UserRoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getRoles(User $user): array
    {
        $roles = $this->repository->findAllByUserId($user->getId())->map(function (UserRole $userRole): string {
            return $userRole->getRoleName();
        });

        return iterator_to_array($roles, false);
    }
}
