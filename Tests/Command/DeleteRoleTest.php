<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Command;

use MsgPhp\User\Command;
use MsgPhp\User\Event;
use MsgPhp\User\Role;
use PHPUnit\Framework\TestCase;

final class DeleteRoleTest extends TestCase
{
    use IntegrationTestTrait;

    public function testDelete(): void
    {
        $repository = self::createRoleRepository();
        $repository->save($role = self::createDomainFactory()->create(Role::class, ['name' => 'ROLE_USER']));

        self::$bus->dispatch(new Command\DeleteRole('ROLE_USER'));

        self::assertMessageIsDispatchedOnce(Event\RoleDeleted::class);
        self::assertCount(0, $repository->findAll());
        self::assertFalse($repository->exists('ROLE_USER'));
    }

    public function testDeleteUnknownName(): void
    {
        self::$bus->dispatch(new Command\DeleteRole('ROLE_FOO'));

        self::assertMessageIsNotDispatched(Event\RoleDeleted::class);
    }
}
