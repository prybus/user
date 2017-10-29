<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\Entity\EntityFactoryInterface;
use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\CreateUserCommand;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Event\UserCreatedEvent;
use MsgPhp\User\PasswordEncoderInterface;
use MsgPhp\User\Repository\UserRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreateUserHandler
{
    private $repository;
    private $factory;
    private $passwordEncoder;
    private $eventBus;

    public function __construct(UserRepositoryInterface $repository, EntityFactoryInterface $factory, PasswordEncoderInterface $passwordEncoder, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventBus = $eventBus;
    }

    public function handle(CreateUserCommand $command): void
    {
        $user = $this->factory->create(User::class, [
            'id' => null === $command->userId ? $this->factory->nextIdentity(User::class) : $command->userId,
            'email' => $command->email,
            'password' => $command->plainPassword ? $this->passwordEncoder->encode($command->password) : $command->password,
        ]);

        if ($command->enable) {
            $user->enable();
        }

        $this->repository->save($user);
        $this->eventBus->handle(new UserCreatedEvent($user));
    }
}
