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

namespace MsgPhp\User\Tests\Entity\Fields;

use MsgPhp\User\Entity\Fields\UserField;
use MsgPhp\User\Entity\User;
use MsgPhp\User\UserIdInterface;
use PHPUnit\Framework\TestCase;

final class UserFieldTest extends TestCase
{
    public function testField(): void
    {
        $value = $this->createMock(User::class);
        $value->expects(self::any())
            ->method('getId')
            ->willReturn($this->createMock(UserIdInterface::class))
        ;

        $object = $this->getObject($value);

        self::assertSame($value, $object->getUser());
        self::assertSame($value->getId(), $object->getUserId());
    }

    /**
     * @return object
     */
    private function getObject($value)
    {
        return new class($value) {
            use UserField;

            public function __construct($value)
            {
                $this->user = $value;
            }
        };
    }
}
