<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Entity;

use MsgPhp\User\Entity\UserRole;
use MsgPhp\User\Infra\PHPUnit\UserEntityTrait;
use PHPUnit\Framework\TestCase;

final class UserRoleTest extends TestCase
{
    use UserEntityTrait;

    public function testCreate()
    {
        $userRole = new UserRole($user = $this->createUser('foo@bar.baz'), 'ROLE_USER');

        $this->assertSame($user, $userRole->getUser());
        $this->assertSame($user->getId(), $userRole->getUserId());
        $this->assertSame('ROLE_USER', $userRole->getRole());
        $this->assertInstanceOf(\DateTime::class, $user->getCreatedAt());
    }
}
