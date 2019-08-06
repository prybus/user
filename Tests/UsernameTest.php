<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests;

use MsgPhp\User\Tests\Fixtures\Entities\TestUsername;
use MsgPhp\User\User;
use PHPUnit\Framework\TestCase;

final class UsernameTest extends TestCase
{
    public function testCreate(): void
    {
        $username = new TestUsername($user = $this->createMock(User::class), 'username');

        self::assertSame($user, $username->getUser());
        self::assertSame('username', $username->toString());
    }
}
