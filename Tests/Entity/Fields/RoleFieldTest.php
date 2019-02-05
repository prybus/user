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

use MsgPhp\User\Entity\Fields\RoleField;
use MsgPhp\User\Entity\Role;
use PHPUnit\Framework\TestCase;

final class RoleFieldTest extends TestCase
{
    public function testField(): void
    {
        $value = $this->createMock(Role::class);
        $value->expects(self::any())
            ->method('getName')
            ->willReturn('ROLE_FOO')
        ;

        $object = $this->getObject($value);

        self::assertSame($value, $object->getRole());
        self::assertSame('ROLE_FOO', $object->getRoleName());
    }

    /**
     * @return object
     */
    private function getObject($value)
    {
        return new class($value) {
            use RoleField;

            public function __construct($value)
            {
                $this->role = $value;
            }
        };
    }
}
