<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\PHPUnit;

use MsgPhp\Domain\Infra\InMemory\DomainId;
use MsgPhp\User\Entity\PendingUser;
use MsgPhp\User\Entity\User;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait UserEntityTrait
{
    private function createUser(string $email, string $password = null, string $id = null): User
    {
        return new User($this->createUserId($id), $email, $password ?? bin2hex(random_bytes(4)));
    }

    private function createUserId(string $id = null): UserIdInterface
    {
        return new UserId($id);
    }

    private function createPendingUser(string $email, string $password = null): PendingUser
    {
        return new PendingUser($email, $password ?? bin2hex(random_bytes(4)));
    }
}

class UserId extends DomainId implements UserIdInterface
{
}
