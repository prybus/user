<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests;

use MsgPhp\User\User;
use MsgPhp\User\Username;
use PHPUnit\Framework\TestCase;

final class UsernameTest extends TestCase
{
    public function testCreate(): void
    {
        $username = $this->createEntity($user = $this->createMock(User::class), 'username');

        self::assertSame($user, $username->getUser());
        self::assertSame('username', $username->toString());
    }

    private function createEntity($user, $username): Username
    {
        return new class($user, $username) extends Username {
        };
    }
}
