<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Credential\Email;
use MsgPhp\User\Event\Domain\ChangeCredential;
use MsgPhp\User\Model\EmailCredential;
use PHPUnit\Framework\TestCase;

final class EmailCredentialTest extends TestCase
{
    public function testCredential(): void
    {
        $model = new TestEmailCredentialModel($credential = new Email('admin@localhost'));

        self::assertSame($credential, $model->getCredential());
        self::assertSame('admin@localhost', $model->getEmail());
        self::assertTrue($model->onChangeCredentialEvent(new ChangeCredential(['email' => 'foo'])));
        self::assertFalse($model->onChangeCredentialEvent(new ChangeCredential(['email' => 'foo'])));
        self::assertSame('foo', $model->getEmail());
    }
}

class TestEmailCredentialModel
{
    use EmailCredential {
        onChangeCredentialEvent as public;
    }

    public function __construct(Email $credential)
    {
        $this->credential = $credential;
    }
}
