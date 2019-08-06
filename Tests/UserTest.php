<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests;

use MsgPhp\User\Credential\Anonymous;
use MsgPhp\User\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testGetCredential(): void
    {
        self::assertInstanceOf(Anonymous::class, $this->getMockForAbstractClass(User::class)->getCredential());
    }
}
