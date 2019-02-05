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

namespace MsgPhp\User\Infra\Doctrine\Repository;

use MsgPhp\Domain\DomainCollectionInterface;
use MsgPhp\Domain\Infra\Doctrine\DomainEntityRepositoryTrait;
use MsgPhp\User\Entity\UserRole;
use MsgPhp\User\Repository\UserRoleRepositoryInterface;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserRoleRepository implements UserRoleRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    /**
     * @return DomainCollectionInterface|UserRole[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = 0, int $limit = 0): DomainCollectionInterface
    {
        return $this->doFindAllByFields(['user' => $userId], $offset, $limit);
    }

    public function find(UserIdInterface $userId, string $roleName): UserRole
    {
        return $this->doFind(['user' => $userId, 'role' => $roleName]);
    }

    public function exists(UserIdInterface $userId, string $roleName): bool
    {
        return $this->doExists(['user' => $userId, 'role' => $roleName]);
    }

    public function save(UserRole $userRole): void
    {
        $this->doSave($userRole);
    }

    public function delete(UserRole $userRole): void
    {
        $this->doDelete($userRole);
    }
}
