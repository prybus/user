<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\CommandBusInterface;
use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\ChangeUserEmailCommand;
use MsgPhp\User\Command\ConfirmUserSecondaryEmailCommand;
use MsgPhp\User\Command\DeleteUserSecondaryEmailCommand;
use MsgPhp\User\Event\UserSecondaryEmailConfirmedEvent;
use MsgPhp\User\Repository\UserSecondaryEmailRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ConfirmUserSecondaryEmailHandler
{
    private $repository;
    private $commandBus;
    private $eventBus;

    public function __construct(UserSecondaryEmailRepositoryInterface $repository, CommandBusInterface $commandBus, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
    }

    public function handle(ConfirmUserSecondaryEmailCommand $command): void
    {
        $userSecondaryEmail = $this->repository->findByToken($command->token);

        if ($userSecondaryEmail->isPendingPrimary()) {
            $this->commandBus->handle(new ChangeUserEmailCommand($userSecondaryEmail->getUserId(), $userSecondaryEmail->getEmail()));
            $this->commandBus->handle(new DeleteUserSecondaryEmailCommand($userSecondaryEmail->getUserId(), $userSecondaryEmail->getEmail()));
        } else {
            $userSecondaryEmail->confirm();

            $this->repository->save($userSecondaryEmail);
        }

        $this->eventBus->handle(new UserSecondaryEmailConfirmedEvent($userSecondaryEmail));
    }
}
