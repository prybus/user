<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\CreateUserCommand;
use MsgPhp\User\Event\UserCreatedEvent;
use MsgPhp\User\Repository\UserRepositoryInterface;
use MsgPhp\User\UserFactory;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreateUserHandler
{
    private $repository;
    private $factory;
    private $eventBus;

    public function __construct(UserRepositoryInterface $repository, UserFactory $factory, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->eventBus = $eventBus;
    }

    public function handle(CreateUserCommand $command): void
    {
        $user = null === $command->userId
            ? $this->factory->createUser($command->email, $command->password, $command->plainPassword)
            : $this->factory->createIdentifiedUser($command->userId, $command->email, $command->password, $command->plainPassword);

        if ($command->enable) {
            $user->enable();
        }

        $this->repository->save($user);
        $this->eventBus->handle(new UserCreatedEvent($user));
    }
}
