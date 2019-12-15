<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests;

use MsgPhp\User\Role;
use MsgPhp\User\Tests\Fixtures\Entities\TestUserRole;
use MsgPhp\User\User;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UserRoleTest extends TestCase
{
    public function testCreate(): void
    {
        $userRole = new TestUserRole($user = $this->createMock(User::class), $role = $this->createMock(Role::class));

        self::assertSame($user, $userRole->getUser());
        self::assertSame($role, $userRole->getRole());
    }
}
