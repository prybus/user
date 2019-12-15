<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Credential\Token;
use MsgPhp\User\Event\Domain\ChangeCredential;
use MsgPhp\User\Model\TokenCredential;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TokenCredentialTest extends TestCase
{
    public function testCredential(): void
    {
        $model = new TestTokenCredentialModel($credential = new Token('random'));

        self::assertSame($credential, $model->getCredential());
        self::assertSame('random', $model->getToken());
        self::assertTrue($model->onChangeCredentialEvent(new ChangeCredential(['token' => 'foo'])));
        self::assertFalse($model->onChangeCredentialEvent(new ChangeCredential(['token' => 'foo'])));
        self::assertSame('foo', $model->getToken());
    }
}

class TestTokenCredentialModel
{
    use TokenCredential {
        onChangeCredentialEvent as public;
    }

    public function __construct(Token $credential)
    {
        $this->credential = $credential;
    }
}
