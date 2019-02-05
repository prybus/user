<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;
use MsgPhp\Domain\Message\{DomainMessageBusInterface, MessageDispatchingTrait};
use MsgPhp\User\Command\CreateRoleCommand;
use MsgPhp\User\Entity\Role;
use MsgPhp\User\Event\RoleCreatedEvent;
use MsgPhp\User\Repository\RoleRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreateRoleHandler
{
    use MessageDispatchingTrait;

    /**
     * @var RoleRepositoryInterface
     */
    private $repository;

    public function __construct(DomainObjectFactoryInterface $factory, DomainMessageBusInterface $bus, RoleRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(CreateRoleCommand $command): void
    {
        $context = $command->context;
        $role = $this->factory->create(Role::class, $context);
        $this->repository->save($role);
        $this->dispatch(RoleCreatedEvent::class, compact('role', 'context'));
    }
}
