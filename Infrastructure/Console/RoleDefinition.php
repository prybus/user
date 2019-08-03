<?php

declare(strict_types=1);

namespace MsgPhp\User\Infrastructure\Console;

use MsgPhp\Domain\Infrastructure\Console\Definition\DomainDefinition;
use MsgPhp\User\Infrastructure\Doctrine\Repository\RoleRepository;
use MsgPhp\User\Role;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class RoleDefinition implements DomainDefinition
{
    private $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function configure(InputDefinition $definition): void
    {
        $definition->addArgument(new InputArgument('role', InputArgument::OPTIONAL, 'The role name'));
    }

    public function getRole(InputInterface $input, StyleInterface $io): Role
    {
        if (null === $role = $input->getArgument('role')) {
            if (!$input->isInteractive()) {
                throw new \LogicException('No value provided for "role".');
            }

            do {
                $role = $io->ask('Role name');
            } while (null === $role);

            $input->setArgument('role', $role);
        }

        return $this->repository->find($role);
    }
}
