<?php

declare(strict_types=1);

namespace MsgPhp\User\Infrastructure\Console\Definition;

use MsgPhp\Domain\Factory\DomainObjectFactory;
use MsgPhp\Domain\Infrastructure\Console\Definition\DomainDefinition;
use MsgPhp\User\Credential\UsernameCredential;
use MsgPhp\User\Infrastructure\Doctrine\Repository\UserRepository;
use MsgPhp\User\User;
use MsgPhp\User\UserId;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserDefinition implements DomainDefinition
{
    private $repository;
    private $factory;

    public function __construct(UserRepository $repository, DomainObjectFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public static function getDisplayName(User $user): string
    {
        $credential = $user->getCredential();

        if ($credential instanceof UsernameCredential) {
            return $credential->getUsername();
        }

        if (false !== ($i = strrpos($type = \get_class($credential), '\\'))) {
            $type = substr($type, $i + 1);
        }

        return lcfirst($type).'@'.$user->getId()->toString();
    }

    public function configure(InputDefinition $definition): void
    {
        $definition->addOption(new InputOption('by-id', null, InputOption::VALUE_NONE, 'Find user by identifier'));
        $definition->addArgument(new InputArgument('user', InputArgument::OPTIONAL, 'The username or user ID'));
    }

    public function getUser(InputInterface $input, StyleInterface $io): User
    {
        $byId = $input->getOption('by-id');

        if (null === $user = $input->getArgument('user')) {
            if (!$input->isInteractive()) {
                throw new \LogicException('No value provided for "user".');
            }

            do {
                $user = $io->ask($byId ? 'Identifier' : 'Username');
            } while (null === $user);

            $input->setArgument('user', $user);
        }

        return $byId
            ? $this->repository->find($this->factory->create(UserId::class, ['value' => $user]))
            : $this->repository->findByUsername($user);
    }
}
