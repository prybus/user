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

namespace MsgPhp\User\Tests\Role;

use MsgPhp\Domain\DomainCollection;
use MsgPhp\User\Entity\{User, UserRole};
use MsgPhp\User\Repository\UserRoleRepositoryInterface;
use MsgPhp\User\Role\UserRoleProvider;
use MsgPhp\User\UserIdInterface;
use PHPUnit\Framework\TestCase;

final class UserRoleProviderTest extends TestCase
{
    public function testRoles(): void
    {
        $user = $this->createMock(User::class);
        $user->expects(self::once())
            ->method('getId')
            ->willReturn($id = $this->createMock(UserIdInterface::class))
        ;
        $userRole = $this->createMock(UserRole::class);
        $userRole
            ->method('getRoleName')
            ->willReturn('ROLE_USER')
        ;
        $repository = $this->createMock(UserRoleRepositoryInterface::class);
        $repository->expects(self::once())
            ->method('findAllByUserId')
            ->with($id)
            ->willReturn(new DomainCollection(['foo' => $userRole]))
        ;

        self::assertSame(['ROLE_USER'], (new UserRoleProvider($repository))->getRoles($user));
    }
}
