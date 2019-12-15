<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Command;

use MsgPhp\User\Command;
use MsgPhp\User\Event;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CreateRoleTest extends TestCase
{
    use IntegrationTestTrait;

    public function testCreate(): void
    {
        self::$bus->dispatch(new Command\CreateRole($context = ['name' => 'ROLE_USER', 'foo' => 'bar']));

        self::assertMessageIsDispatchedOnce(Event\RoleCreated::class);

        /** @var Event\RoleCreated $event */
        $event = self::$dispatchedMessages[Event\RoleCreated::class][0];
        $repository = self::createRoleRepository();

        self::assertSame($context, $event->context);
        self::assertCount(1, $repository->findAll());
        self::assertSame($event->role, $repository->find('ROLE_USER'));
    }
}
