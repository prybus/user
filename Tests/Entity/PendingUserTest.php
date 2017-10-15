<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Entity;

use MsgPhp\User\Infra\PHPUnit\UserEntityTrait;
use PHPUnit\Framework\TestCase;

final class PendingUserTest extends TestCase
{
    use UserEntityTrait;

    public function testCreate()
    {
        $user = $this->createPendingUser('foo@bar.baz', 'secret');

        $this->assertNotSame($this->createPendingUser('foo@bar.baz', 'secret')->getToken(), $user->getToken());
        $this->assertSame('foo@bar.baz', $user->getEmail());
        $this->assertSame('secret', $user->getPassword());
        $this->assertInstanceOf(\DateTime::class, $user->getCreatedAt());
    }
}
