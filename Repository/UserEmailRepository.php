<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\User\UserEmail;
use MsgPhp\User\UserId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template T of UserEmail
 */
interface UserEmailRepository
{
    /**
     * @return DomainCollection<array-key, T>
     */
    public function findAllByUserId(UserId $userId, int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @return T
     */
    public function find(string $email): UserEmail;

    public function exists(string $email): bool;

    /**
     * @param T $userEmail
     */
    public function save(UserEmail $userEmail): void;

    /**
     * @param T $userEmail
     */
    public function delete(UserEmail $userEmail): void;
}
