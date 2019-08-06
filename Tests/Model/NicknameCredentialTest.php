<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Credential\Nickname;
use MsgPhp\User\Event\Domain\ChangeCredential;
use MsgPhp\User\Model\NicknameCredential;
use PHPUnit\Framework\TestCase;

final class NicknameCredentialTest extends TestCase
{
    public function testCredential(): void
    {
        $model = new TestNicknameCredentialModel($credential = new Nickname('admin'));

        self::assertSame($credential, $model->getCredential());
        self::assertSame('admin', $model->getNickname());
        self::assertTrue($model->onChangeCredentialEvent(new ChangeCredential(['nickname' => 'foo'])));
        self::assertFalse($model->onChangeCredentialEvent(new ChangeCredential(['nickname' => 'foo'])));
        self::assertSame('foo', $model->getNickname());
    }
}

class TestNicknameCredentialModel
{
    use NicknameCredential {
        onChangeCredentialEvent as public;
    }

    public function __construct(Nickname $credential)
    {
        $this->credential = $credential;
    }
}
