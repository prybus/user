<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests;

use MsgPhp\User\Tests\Fixtures\Entities\TestUserEmail;
use MsgPhp\User\User;
use PHPUnit\Framework\TestCase;

final class UserEmailTest extends TestCase
{
    public function testCreate(): void
    {
        $userEmail = new TestUserEmail($user = $this->createMock(User::class), 'user@localhost');

        self::assertSame($user, $userEmail->getUser());
        self::assertSame('user@localhost', $userEmail->getEmail());
    }
}
