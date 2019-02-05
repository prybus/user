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

use MsgPhp\User\Entity\{User, UserEmail};
use PHPUnit\Framework\TestCase;

final class UserEmailTest extends TestCase
{
    public function testCreate(): void
    {
        $userEmail = $this->createEntity($user = $this->createMock(User::class), 'foo@bar.baz');

        self::assertSame($user, $userEmail->getUser());
        self::assertSame('foo@bar.baz', $userEmail->getEmail());
    }

    private function createEntity($user, $email): UserEmail
    {
        return new class($user, $email) extends UserEmail {
        };
    }
}
