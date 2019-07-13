<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\User\User;
use MsgPhp\User\UserId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template T of User
 */
interface UserRepository
{
    /**
     * @return DomainCollection<array-key, T>
     */
    public function findAll(int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @return T
     */
    public function find(UserId $id): User;

    /**
     * @return T
     */
    public function findByUsername(string $username): User;

    public function exists(UserId $id): bool;

    public function usernameExists(string $username): bool;

    /**
     * @param T $user
     */
    public function save(User $user): void;

    /**
     * @param T $user
     */
    public function delete(User $user): void;
}
