<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\User\Role;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template T of Role
 */
interface RoleRepository
{
    /**
     * @return DomainCollection<array-key, T>
     */
    public function findAll(int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @return T
     */
    public function find(string $name): Role;

    public function exists(string $name): bool;

    /**
     * @param T $role
     */
    public function save(Role $role): void;

    /**
     * @param T $role
     */
    public function delete(Role $role): void;
}
