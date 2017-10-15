<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Entity;

use MsgPhp\User\Entity\UserSecondaryEmail;
use MsgPhp\User\Infra\PHPUnit\UserEntityTrait;
use PHPUnit\Framework\TestCase;

final class UserSecondaryEmailTest extends TestCase
{
    use UserEntityTrait;

    public function testCreate()
    {
        $userEmail = new UserSecondaryEmail($user = $this->createUser('foo@bar.baz'), 'other@bar.baz');

        $this->assertSame($user, $userEmail->getUser());
        $this->assertSame($user->getId(), $userEmail->getUserId());
        $this->assertSame('other@bar.baz', $userEmail->getEmail());
        $this->assertTrue(is_string($userEmail->getToken()));
        $this->assertFalse($userEmail->isPendingPrimary());
        $this->assertNull($userEmail->getConfirmedAt());
        $this->assertInstanceOf(\DateTime::class, $userEmail->getCreatedAt());
    }

    public function testCreateDuplicateEmail()
    {
        $this->expectException(\LogicException::class);

        new UserSecondaryEmail($this->createUser('foo@bar.baz'), 'foo@bar.baz');
    }

    public function testConfirm()
    {
        $userEmail = new UserSecondaryEmail($user = $this->createUser('foo@bar.baz'), 'other@bar.baz');
        $userEmail->confirm();

        $compareUserEmail = new UserSecondaryEmail($this->createUser('foo@bar.baz'), 'other@bar.baz');
        $this->assertNotSame($userEmail->getToken(), $compareUserEmail->getToken());

        $this->assertNull($userEmail->getToken());
        $this->assertInstanceOf(\DateTime::class, $userEmail->getConfirmedAt());
    }

    public function testMarkPendingPrimary()
    {
        $userEmail = new UserSecondaryEmail($this->createUser('foo@bar.baz'), 'other@bar.baz');
        $userEmail->markPendingPrimary();

        $this->assertTrue($userEmail->isPendingPrimary());

        $userEmail->markPendingPrimary(false);

        $this->assertFalse($userEmail->isPendingPrimary());

        $userEmail->confirm();

        $this->expectException(\LogicException::class);

        $userEmail->markPendingPrimary();
    }
}
