<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\CommandBusInterface;
use MsgPhp\User\Command\ChangeUserPasswordCommand;
use MsgPhp\User\Command\ResetUserPasswordCommand;
use MsgPhp\User\Repository\UserRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ResetUserPasswordHandler
{
    private $repository;
    private $commandBus;

    public function __construct(UserRepositoryInterface $repository, CommandBusInterface $commandBus)
    {
        $this->repository = $repository;
        $this->commandBus = $commandBus;
    }

    public function handle(ResetUserPasswordCommand $command): void
    {
        $user = $this->repository->findByPasswordResetToken($command->token);

        $this->commandBus->handle(new ChangeUserPasswordCommand($user->getId(), $command->password));
    }
}
