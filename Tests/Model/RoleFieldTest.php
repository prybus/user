<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Model\RoleField;
use MsgPhp\User\Role;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class RoleFieldTest extends TestCase
{
    public function testField(): void
    {
        $role = $this->createMock(Role::class);
        $role->expects(self::any())
            ->method('getName')
            ->willReturn('ROLE_FOO')
        ;
        $model = new TestRoleFieldModel($role);

        self::assertSame($role, $model->getRole());
        self::assertSame('ROLE_FOO', $model->getRoleName());
    }
}

class TestRoleFieldModel
{
    use RoleField;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
