<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Credential\Credential;
use MsgPhp\User\Event\Domain\CancelPasswordRequest;
use MsgPhp\User\Event\Domain\FinishPasswordRequest;
use MsgPhp\User\Event\Domain\RequestPassword;
use MsgPhp\User\Model\ResettablePassword;
use PHPUnit\Framework\TestCase;

final class ResettablePasswordTest extends TestCase
{
    public function testRequest(): void
    {
        $now = new \DateTimeImmutable();
        $model = new TestResettablePasswordModel();

        self::assertNull($model->getPasswordResetToken());
        self::assertNull($model->getPasswordRequestedAt());

        $model->requestPassword('random');

        self::assertSame('random', $model->getPasswordResetToken());
        self::assertInstanceOf(\DateTimeImmutable::class, $model->getPasswordRequestedAt());
        self::assertGreaterThan($now, $now = $model->getPasswordRequestedAt());
        self::assertTrue($model->onRequestPasswordEvent(new RequestPassword('random2')));
        self::assertSame('random2', $model->getPasswordResetToken());
        self::assertInstanceOf(\DateTimeImmutable::class, $model->getPasswordRequestedAt());
        self::assertGreaterThan($now, $model->getPasswordRequestedAt());
    }

    public function testRequestRandom(): void
    {
        $now = new \DateTimeImmutable();
        $model = new TestResettablePasswordModel();
        $model->requestPassword();

        self::assertNotNull($token = $model->getPasswordResetToken());
        self::assertInstanceOf(\DateTimeImmutable::class, $model->getPasswordRequestedAt());
        self::assertGreaterThan($now, $now = $model->getPasswordRequestedAt());
        self::assertTrue($model->onRequestPasswordEvent(new RequestPassword()));
        self::assertNotNull($model->getPasswordResetToken());
        self::assertNotSame($token, $model->getPasswordResetToken());
        self::assertInstanceOf(\DateTimeImmutable::class, $model->getPasswordRequestedAt());
        self::assertGreaterThan($now, $model->getPasswordRequestedAt());
    }

    public function testAbort(): void
    {
        $model = new TestResettablePasswordModel();
        $model->requestPassword();
        $model->abortPasswordRequest();

        self::assertNull($model->getPasswordResetToken());
        self::assertNull($model->getPasswordRequestedAt());

        $model->onRequestPasswordEvent(new RequestPassword('random'));

        self::assertTrue($model->onCancelPasswordRequestEvent(new CancelPasswordRequest()));
        self::assertNull($model->getPasswordResetToken());
        self::assertNull($model->getPasswordRequestedAt());
        self::assertFalse($model->onCancelPasswordRequestEvent(new CancelPasswordRequest()));

        $model->onRequestPasswordEvent(new RequestPassword());

        self::assertTrue($model->onFinishPasswordRequestEvent(new FinishPasswordRequest($this->createMock(Credential::class))));
        self::assertNull($model->getPasswordResetToken());
        self::assertNull($model->getPasswordRequestedAt());
        self::assertFalse($model->onFinishPasswordRequestEvent(new FinishPasswordRequest($this->createMock(Credential::class))));
    }
}

class TestResettablePasswordModel
{
    use ResettablePassword {
        onRequestPasswordEvent as public;
        onCancelPasswordRequestEvent as public;
        onFinishPasswordRequestEvent as public;
    }
}
