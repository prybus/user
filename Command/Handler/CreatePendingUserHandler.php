<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\Entity\EntityFactoryInterface;
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
    private $factory;
    private $passwordEncoder;
    private $eventBus;

    public function __construct(PendingUserRepositoryInterface $repository, EntityFactoryInterface $factory, PasswordEncoderInterface $passwordEncoder, EventBusInterface $eventBus = null)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventBus = $eventBus;
    }

    public function handle(CreatePendingUserCommand $command): void
    {
        $pendingUser = $this->factory->create(PendingUser::class, [
            'email' => $command->email,
            'password' => $command->plainPassword ? $this->passwordEncoder->encode($command->password) : $command->password,
        ] + $command->context);

        $this->repository->save($pendingUser);

        if (null !== $this->eventBus) {
            $this->eventBus->handle(new PendingUserCreatedEvent($pendingUser));
        }
    }
}
