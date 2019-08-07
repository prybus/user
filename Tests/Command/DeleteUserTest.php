<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Command;

use MsgPhp\User\Command;
use MsgPhp\User\Event;
use MsgPhp\User\User;
use MsgPhp\User\UserId;
use PHPUnit\Framework\TestCase;

final class DeleteUserTest extends TestCase
{
    use IntegrationTestTrait;

    public function testDelete(): void
    {
        $repository = self::createUserRepository();
        $repository->save($user = self::createDomainFactory()->create(User::class, [
            'email' => 'user@localhost',
            'password' => 'pa$$word',
        ]));

        self::$bus->dispatch(new Command\DeleteUser($user->getId()));

        self::assertMessageIsDispatchedOnce(Event\UserDeleted::class);
        self::assertCount(0, $repository->findAll());
        self::assertFalse($repository->usernameExists('user@localhost'));
    }

    public function testDeleteUnknownId(): void
    {
        self::$bus->dispatch(new Command\DeleteUser(self::createDomainFactory()->create(UserId::class)));

        self::assertMessageIsNotDispatched(Event\UserDeleted::class);
    }
}
