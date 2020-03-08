<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\User\Username;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template T of Username
 */
interface UsernameRepository
{
    /**
     * @return DomainCollection<int, T>
     */
    public function lookup(): DomainCollection;

    /**
     * @return DomainCollection<string, T>
     */
    public function findAll(int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @return T
     */
    public function find(string $username): Username;

    public function exists(string $username): bool;

    /**
     * @param T $username
     */
    public function save(Username $username): void;

    /**
     * @param T $username
     */
    public function delete(Username $username): void;
}
