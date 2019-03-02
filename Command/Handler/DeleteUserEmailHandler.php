<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\Exception\EntityNotFoundException;
use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;
use MsgPhp\Domain\Message\DomainMessageBusInterface;
use MsgPhp\Domain\Message\MessageDispatchingTrait;
use MsgPhp\User\Command\DeleteUserEmailCommand;
use MsgPhp\User\Event\UserEmailDeletedEvent;
use MsgPhp\User\Repository\UserEmailRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DeleteUserEmailHandler
{
    use MessageDispatchingTrait;

    /**
     * @var UserEmailRepositoryInterface
     */
    private $repository;

    public function __construct(DomainObjectFactoryInterface $factory, DomainMessageBusInterface $bus, UserEmailRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(DeleteUserEmailCommand $command): void
    {
        try {
            $userEmail = $this->repository->find($command->email);
        } catch (EntityNotFoundException $e) {
            return;
        }

        $this->repository->delete($userEmail);
        $this->dispatch(UserEmailDeletedEvent::class, compact('userEmail'));
    }
}
