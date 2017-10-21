<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\CommandBusInterface;
use MsgPhp\Domain\EventBusInterface;
use MsgPhp\Domain\Exception\EntityNotFoundException;
use MsgPhp\User\Command\SetUserPendingPrimaryEmailCommand;
use MsgPhp\User\Event\UserPendingPrimaryEmailCancelledEvent;
use MsgPhp\User\Event\UserPendingPrimaryEmailSetEvent;
use MsgPhp\User\Event\UserSecondaryEmailAddedEvent;
use MsgPhp\User\Repository\UserRepositoryInterface;
use MsgPhp\User\Repository\UserSecondaryEmailRepositoryInterface;
use MsgPhp\User\UserFactory;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class SetUserPendingPrimaryEmailHandler
{
    private $userRepository;
    private $userSecondaryEmailRepository;
    private $factory;
    private $commandBus;
    private $eventBus;

    public function __construct(UserRepositoryInterface $userRepository, UserSecondaryEmailRepositoryInterface $userSecondaryEmailRepository, UserFactory $factory, CommandBusInterface $commandBus, EventBusInterface $eventBus)
    {
        $this->userRepository = $userRepository;
        $this->userSecondaryEmailRepository = $userSecondaryEmailRepository;
        $this->factory = $factory;
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
    }

    public function handle(SetUserPendingPrimaryEmailCommand $command): void
    {
        $user = $this->userRepository->find($command->userId);

        if ($command->email === $user->getEmail()) {
            return;
        }

        try {
            $currentPendingPrimaryEmail = $this->userSecondaryEmailRepository->findPendingPrimary($user->getId());

            if ($command->email === $currentPendingPrimaryEmail->getEmail()) {
                return;
            }

            $currentPendingPrimaryEmail->markPendingPrimary(false);

            $this->userSecondaryEmailRepository->save($currentPendingPrimaryEmail);
        } catch (EntityNotFoundException $e) {
            $currentPendingPrimaryEmail = null;
        }

        if (null === $command->email) {
            if (null !== $currentPendingPrimaryEmail) {
                $this->eventBus->handle(new UserPendingPrimaryEmailCancelledEvent($currentPendingPrimaryEmail));
            }

            return;
        }

        try {
            $userSecondaryEmail = $this->userSecondaryEmailRepository->find($user->getId(), $command->email);

            if ($userSecondaryEmail->isPendingPrimary()) {
                return;
            }

            $userSecondaryEmail->markPendingPrimary();

            $this->userSecondaryEmailRepository->save($userSecondaryEmail);
        } catch (EntityNotFoundException $e) {
            $userSecondaryEmail = $this->factory->createUserSecondaryEmail($user, $command->email);

            $userSecondaryEmail->markPendingPrimary();

            $this->userSecondaryEmailRepository->save($userSecondaryEmail);
            $this->eventBus->handle(new UserSecondaryEmailAddedEvent($userSecondaryEmail));
        }

        $this->eventBus->handle(new UserPendingPrimaryEmailSetEvent($userSecondaryEmail));
    }
}
