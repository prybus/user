<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\CreatePendingUserCommand;
use MsgPhp\User\Entity\PendingUser;
use MsgPhp\User\Event\PendingUserCreatedEvent;
use MsgPhp\User\PasswordEncoderInterface;
use MsgPhp\User\Repository\PendingUserRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreatePendingUserHandler
{
    private $repository;
    private $passwordEncoder;
    private $eventBus;

    public function __construct(PendingUserRepositoryInterface $repository, PasswordEncoderInterface $passwordEncoder, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventBus = $eventBus;
    }

    public function handle(CreatePendingUserCommand $command): void
    {
        $user = new PendingUser($command->email, $this->passwordEncoder->encode($command->password));

        $this->repository->save($user);
        $this->eventBus->handle(new PendingUserCreatedEvent($user));
    }
}