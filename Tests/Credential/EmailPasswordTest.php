<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\EmailPassword;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EmailPasswordTest extends TestCase
{
    public function testCredential(): void
    {
        $credential = new EmailPassword('admin@localhost', 'pa$$word');

        self::assertSame('email', $credential::getUsernameField());
        self::assertSame('password', $credential::getPasswordField());
        self::assertSame('admin@localhost', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
    }

    public function testInvoke(): void
    {
        $credential = new EmailPassword('admin@localhost', 'pa$$word');

        self::assertFalse($credential(new ChangeCredential(['foo' => 'bar'])));
        self::assertSame('admin@localhost', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
        self::assertTrue($credential(new ChangeCredential(['email' => 'new-username', 'foo' => 'bar'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
        self::assertFalse($credential(new ChangeCredential(['email' => 'new-username'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
        self::assertTrue($credential(new ChangeCredential(['email' => 'admin@localhost', 'password' => 'new-password', 'foo' => 'bar'])));
        self::assertSame('admin@localhost', $credential->getUsername());
        self::assertSame('new-password', $credential->getPassword());
        self::assertFalse($credential(new ChangeCredential(['email' => 'admin@localhost', 'password' => 'new-password'])));
        self::assertSame('admin@localhost', $credential->getUsername());
        self::assertSame('new-password', $credential->getPassword());
    }
}
