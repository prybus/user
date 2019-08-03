<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\Token;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

final class TokenTest extends TestCase
{
    public function testCredential(): void
    {
        $credential = new Token('username');

        self::assertSame('token', $credential::getUsernameField());
        self::assertSame('username', $credential->getUsername());
    }

    public function testInvoke(): void
    {
        $credential = new Token('username');

        self::assertFalse($credential(new ChangeCredential(['foo' => 'bar'])));
        self::assertSame('username', $credential->getUsername());
        self::assertTrue($credential(new ChangeCredential(['token' => 'new-username', 'foo' => 'bar'])));
        self::assertSame('new-username', $credential->getUsername());
        self::assertFalse($credential(new ChangeCredential(['token' => 'new-username'])));
        self::assertSame('new-username', $credential->getUsername());
    }
}
