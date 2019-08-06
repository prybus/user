<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Credential\NicknamePassword;
use MsgPhp\User\Event\Domain\ChangeCredential;
use MsgPhp\User\Model\NicknamePasswordCredential;
use PHPUnit\Framework\TestCase;

final class NicknamePasswordCredentialTest extends TestCase
{
    public function testCredential(): void
    {
        $model = new TestNicknamePasswordCredentialModel($credential = new NicknamePassword('admin', 'pa$$word'));

        self::assertSame($credential, $model->getCredential());
        self::assertSame('admin', $model->getNickname());
        self::assertSame('pa$$word', $model->getPassword());
        self::assertTrue($model->onChangeCredentialEvent(new ChangeCredential(['nickname' => 'foo', 'password' => 'bar'])));
        self::assertFalse($model->onChangeCredentialEvent(new ChangeCredential(['nickname' => 'foo'])));
        self::assertSame('foo', $model->getNickname());
        self::assertSame('bar', $model->getPassword());
    }
}

class TestNicknamePasswordCredentialModel
{
    use NicknamePasswordCredential {
        onChangeCredentialEvent as public;
    }

    public function __construct(NicknamePassword $credential)
    {
        $this->credential = $credential;
    }
}
