<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\Nickname;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class NicknameTest extends TestCase
{
    public function testCredential(): void
    {
        $credential = new Nickname('admin');

        self::assertSame('nickname', $credential::getUsernameField());
        self::assertSame('admin', $credential->getUsername());
    }

    public function testInvoke(): void
    {
        $credential = new Nickname('admin');

        self::assertFalse($credential(new ChangeCredential(['foo' => 'bar'])));
        self::assertSame('admin', $credential->getUsername());
        self::assertTrue($credential(new ChangeCredential(['nickname' => 'new-username', 'foo' => 'bar'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertFalse($credential(new ChangeCredential(['nickname' => 'new-username'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertTrue($credential(new ChangeCredential(['nickname' => 'admin'])));
        self::assertSame('admin', $credential->getUsername());
    }
}
