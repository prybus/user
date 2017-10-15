<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\EventBusInterface;
use MsgPhp\User\Command\ChangeUserPasswordCommand;
use MsgPhp\User\Event\UserPasswordChangedEvent;
use MsgPhp\User\PasswordEncoderInterface;
use MsgPhp\User\Repository\UserRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ChangeUserPasswordHandler
{
    private $repository;
    private $passwordEncoder;
    private $eventBus;

    public function __construct(UserRepositoryInterface $repository, PasswordEncoderInterface $passwordEncoder, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventBus = $eventBus;
    }

    public function handle(ChangeUserPasswordCommand $command): void
    {
        $user = $this->repository->find($command->userId);
        $password = $this->passwordEncoder->encode($command->password);

        if ($password === $oldPassword = $user->getPassword()) {
            return;
        }

        $user->changePassword($password);

        $this->repository->save($user);
        $this->eventBus->handle(new UserPasswordChangedEvent($user, $oldPassword));
    }
}
