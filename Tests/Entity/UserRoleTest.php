<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\User\Tests\Entity;

use MsgPhp\User\Entity\{Role, User, UserRole};
use PHPUnit\Framework\TestCase;

final class UserRoleTest extends TestCase
{
    public function testCreate(): void
    {
        $userRole = $this->createEntity($user = $this->createMock(User::class), $role = $this->createMock(Role::class));

        self::assertSame($user, $userRole->getUser());
        self::assertSame($role, $userRole->getRole());
    }

    private function createEntity($user, $role): UserRole
    {
        return new class($user, $role) extends UserRole {
        };
    }
}
