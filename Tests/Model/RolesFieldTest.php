<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Model\RolesField;
use MsgPhp\User\UserRole;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class RolesFieldTest extends TestCase
{
    public function testField(): void
    {
        self::assertSame($roles = [$this->createMock(UserRole::class)], iterator_to_array((new TestRolesFieldModel($roles))->getRoles()));
    }
}

class TestRolesFieldModel
{
    use RolesField;

    /**
     * @param iterable<array-key, UserRole> $roles
     */
    public function __construct(iterable $roles)
    {
        $this->roles = $roles;
    }
}
