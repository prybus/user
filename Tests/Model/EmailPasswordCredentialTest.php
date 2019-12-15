<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Credential\EmailPassword;
use MsgPhp\User\Event\Domain\ChangeCredential;
use MsgPhp\User\Model\EmailPasswordCredential;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EmailPasswordCredentialTest extends TestCase
{
    public function testCredential(): void
    {
        $model = new TestEmailPasswordCredentialModel($credential = new EmailPassword('admin@localhost', 'pa$$word'));

        self::assertSame($credential, $model->getCredential());
        self::assertSame('admin@localhost', $model->getEmail());
        self::assertSame('pa$$word', $model->getPassword());
        self::assertTrue($model->onChangeCredentialEvent(new ChangeCredential(['email' => 'foo', 'password' => 'bar'])));
        self::assertFalse($model->onChangeCredentialEvent(new ChangeCredential(['email' => 'foo'])));
        self::assertSame('foo', $model->getEmail());
        self::assertSame('bar', $model->getPassword());
    }
}

class TestEmailPasswordCredentialModel
{
    use EmailPasswordCredential {
        onChangeCredentialEvent as public;
    }

    public function __construct(EmailPassword $credential)
    {
        $this->credential = $credential;
    }
}
