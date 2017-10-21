<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\CreatePendingUserCommand;
use MsgPhp\User\Event\PendingUserCreatedEvent;
use MsgPhp\User\Repository\PendingUserRepositoryInterface;
use MsgPhp\User\UserFactory;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreatePendingUserHandler
{
    private $repository;
    private $factory;
    private $eventBus;

    public function __construct(PendingUserRepositoryInterface $repository, UserFactory $factory, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->eventBus = $eventBus;
    }

    public function handle(CreatePendingUserCommand $command): void
    {
        $pendingUser = $this->factory->createPendingUser($command->email, $command->password);

        $this->repository->save($pendingUser);
        $this->eventBus->handle(new PendingUserCreatedEvent($pendingUser));
    }
}
