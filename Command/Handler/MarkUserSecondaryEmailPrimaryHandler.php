<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\CommandBusInterface;
use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\AddUserSecondaryEmailCommand;
use MsgPhp\User\Command\ChangeUserEmailCommand;
use MsgPhp\User\Command\DeleteUserSecondaryEmailCommand;
use MsgPhp\User\Command\MarkUserSecondaryEmailPrimaryCommand;
use MsgPhp\User\Command\SetUserPendingPrimaryEmailCommand;
use MsgPhp\User\Event\UserSecondaryEmailMarkedPrimaryEvent;
use MsgPhp\User\Repository\UserSecondaryEmailRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class MarkUserSecondaryEmailPrimaryHandler
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

    public function handle(MarkUserSecondaryEmailPrimaryCommand $command): void
    {
        $userSecondaryEmail = $this->repository->find($command->userId, $command->email);
        $currentPrimaryEmail = $userSecondaryEmail->getUser()->getEmail();

        if ($userSecondaryEmail->getConfirmedAt()) {
            $this->commandBus->handle(new ChangeUserEmailCommand($command->userId, $command->email));
            $this->commandBus->handle(new DeleteUserSecondaryEmailCommand($command->userId, $command->email));
            $this->commandBus->handle(new AddUserSecondaryEmailCommand($command->userId, $currentPrimaryEmail, true));
        } else {
            $this->commandBus->handle(new SetUserPendingPrimaryEmailCommand($command->userId, $command->email));
        }

        $this->eventBus->handle(new UserSecondaryEmailMarkedPrimaryEvent($userSecondaryEmail));
    }
}
