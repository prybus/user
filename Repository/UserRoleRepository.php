<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\User\UserId;
use MsgPhp\User\UserRole;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template T of UserRole
 */
interface UserRoleRepository
{
    /**
     * @return DomainCollection<array-key, T>
     */
    public function findAllByUserId(UserId $userId, int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @return T
     */
    public function find(UserId $userId, string $roleName): UserRole;

    public function exists(UserId $userId, string $roleName): bool;

    /**
     * @param T $userRole
     */
    public function save(UserRole $userRole): void;

    /**
     * @param T $userRole
     */
    public function delete(UserRole $userRole): void;
}
