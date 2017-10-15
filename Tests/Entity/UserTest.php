<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Entity;

use MsgPhp\User\Infra\PHPUnit\UserEntityTrait;
use MsgPhp\User\Infra\PHPUnit\UserId;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    use UserEntityTrait;

    public function testCreate()
    {
        $user = $this->createUser('foo@bar.baz', 'secret', '1');

        $this->assertTrue($user->getId()->equals(new UserId('1')));
        $this->assertSame('foo@bar.baz', $user->getEmail());
        $this->assertSame('secret', $user->getPassword());
        $this->assertFalse($user->isEnabled());
        $this->assertInstanceOf(\DateTime::class, $user->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $user->getLastUpdatedAt());
        $this->assertNull($user->getPasswordResetToken());
        $this->assertNull($user->getPasswordRequestedAt());
    }

    public function testChangeEmail()
    {
        $user = $this->createUser('foo@bar.baz');
        $lastUpdatedAt = $user->getLastUpdatedAt();

        $user->changeEmail('other@bar.baz');

        $this->assertSame('other@bar.baz', $user->getEmail());
        $this->assertGreaterThanOrEqual($lastUpdatedAt, $user->getLastUpdatedAt());
    }

    public function testChangePassword()
    {
        $user = $this->createUser('foo@bar.baz');
        $lastUpdatedAt = $user->getLastUpdatedAt();

        $user->changePassword('other');

        $this->assertSame('other', $user->getPassword());
        $this->assertGreaterThanOrEqual($lastUpdatedAt, $user->getLastUpdatedAt());
    }

    public function testRequestPassword()
    {
        $user = $this->createUser('foo@bar.baz');
        $lastUpdatedAt = $user->getLastUpdatedAt();

        $user->requestPassword();

        $this->assertTrue(is_string($user->getPasswordResetToken()));
        $this->assertGreaterThanOrEqual($lastUpdatedAt, $user->getLastUpdatedAt());
        $this->assertGreaterThanOrEqual($lastUpdatedAt, $user->getPasswordRequestedAt());
        $this->assertGreaterThanOrEqual($user->getPasswordRequestedAt(), $user->getLastUpdatedAt());

        ($compareUser = $this->createUser('foo@bar.baz'))->requestPassword();
        $this->assertNotSame($user->getPasswordResetToken(), $compareUser->getPasswordResetToken());
    }

    public function testEnableDisable()
    {
        $user = $this->createUser('foo@bar.baz');
        $lastUpdatedAt = $user->getLastUpdatedAt();

        $user->enable();

        $this->assertTrue($user->isEnabled());
        $this->assertGreaterThanOrEqual($lastUpdatedAt, $lastUpdatedAt = $user->getLastUpdatedAt());

        $user->disable();

        $this->assertFalse($user->isEnabled());
        $this->assertGreaterThanOrEqual($lastUpdatedAt, $user->getLastUpdatedAt());
    }
}
