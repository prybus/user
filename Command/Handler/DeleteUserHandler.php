<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\CreateUserCommand;
use MsgPhp\User\Event\UserDeletedEvent;
use MsgPhp\User\Repository\UserRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DeleteUserHandler
{
    private $repository;
    private $eventBus;

    public function __construct(UserRepositoryInterface $repository, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function handle(CreateUserCommand $command): void
    {
        $user = $this->repository->find($command->userId);

        $this->repository->delete($user);
        $this->eventBus->handle(new UserDeletedEvent($user));
    }
}
