<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\EmailPassword;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

final class EmailPasswordTest extends TestCase
{
    public function testCredential(): void
    {
        $credential = new EmailPassword('username', 'password');

        self::assertSame('email', $credential::getUsernameField());
        self::assertSame('username', $credential->getUsername());
        self::assertSame('password', $credential->getPassword());
    }

    public function testInvoke(): void
    {
        $credential = new EmailPassword('username', 'password');

        self::assertFalse($credential(new ChangeCredential(['foo' => 'bar'])));
        self::assertSame('username', $credential->getUsername());
        self::assertSame('password', $credential->getPassword());
        self::assertTrue($credential(new ChangeCredential(['email' => 'new-username', 'foo' => 'bar'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertSame('password', $credential->getPassword());
        self::assertFalse($credential(new ChangeCredential(['email' => 'new-username'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertSame('password', $credential->getPassword());
        self::assertTrue($credential(new ChangeCredential(['email' => 'username', 'password' => 'new-password', 'foo' => 'bar'])));
        self::assertSame('username', $credential->getUsername());
        self::assertSame('new-password', $credential->getPassword());
        self::assertFalse($credential(new ChangeCredential(['email' => 'username', 'password' => 'new-password'])));
        self::assertSame('username', $credential->getUsername());
        self::assertSame('new-password', $credential->getPassword());
    }
}
