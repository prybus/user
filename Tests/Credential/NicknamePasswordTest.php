<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\NicknamePassword;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class NicknamePasswordTest extends TestCase
{
    public function testCredential(): void
    {
        $credential = new NicknamePassword('admin', 'pa$$word');

        self::assertSame('nickname', $credential::getUsernameField());
        self::assertSame('password', $credential::getPasswordField());
        self::assertSame('admin', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
    }

    public function testInvoke(): void
    {
        $credential = new NicknamePassword('admin', 'pa$$word');

        self::assertFalse($credential(new ChangeCredential(['foo' => 'bar'])));
        self::assertSame('admin', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
        self::assertTrue($credential(new ChangeCredential(['nickname' => 'new-username', 'foo' => 'bar'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
        self::assertFalse($credential(new ChangeCredential(['nickname' => 'new-username'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertSame('pa$$word', $credential->getPassword());
        self::assertTrue($credential(new ChangeCredential(['nickname' => 'admin', 'password' => 'new-password', 'foo' => 'bar'])));
        self::assertSame('admin', $credential->getUsername());
        self::assertSame('new-password', $credential->getPassword());
        self::assertFalse($credential(new ChangeCredential(['nickname' => 'admin', 'password' => 'new-password'])));
        self::assertSame('admin', $credential->getUsername());
        self::assertSame('new-password', $credential->getPassword());
    }
}
