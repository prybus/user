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

namespace MsgPhp\User\Infra\Console\Command;

use MsgPhp\User\Entity\Role;
use MsgPhp\User\Repository\RoleRepositoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait RoleAwareTrait
{
    /**
     * @var RoleRepositoryInterface
     */
    private $repository;

    protected function getRole(InputInterface $input, StyleInterface $io): Role
    {
        if (null === $name = $input->getArgument('role')) {
            if (!$input->isInteractive()) {
                throw new \LogicException('No value provided for "role".');
            }

            do {
                $name = $io->ask('Role name');
            } while (null === $name);

            $input->setArgument('role', $name);
        }

        return $this->repository->find($name);
    }
}
