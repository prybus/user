<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Command;

use MsgPhp\User\Command;
use MsgPhp\User\Event;
use MsgPhp\User\UserId;
use PHPUnit\Framework\TestCase;

final class CreateUserTest extends TestCase
{
    use IntegrationTestTrait;

    public function testCreate(): void
    {
        self::$bus->dispatch(new Command\CreateUser(['foo' => 'bar']));

        self::assertMessageIsDispatchedOnce(Event\UserCreated::class);

        /** @var Event\UserCreated $event */
        $event = self::$dispatchedMessages[Event\UserCreated::class][0];
        $repository = self::createUserRepository();

        self::assertSame('bar', $event->context['foo'] ?? null);
        self::assertInstanceOf(UserId::class, $event->context['id'] ?? null);
        self::assertTrue($event->context['id']->isEmpty());
        self::assertCount(1, $repository->findAll());
        self::assertSame($event->user, $repository->find($event->user->getId()));
    }

    public function testCreateWithId(): void
    {
        self::$bus->dispatch(new Command\CreateUser([
            'id' => $id = self::createDomainFactory()->create(UserId::class),
        ]));

        self::assertMessageIsDispatchedOnce(Event\UserCreated::class);

        /** @var Event\UserCreated $event */
        $event = self::$dispatchedMessages[Event\UserCreated::class][0];
        $repository = self::createUserRepository();

        self::assertSame($id, $event->context['id'] ?? null);
        self::assertFalse($event->user->getId()->isEmpty());
        self::assertTrue($repository->exists($event->user->getId()));
    }
}
