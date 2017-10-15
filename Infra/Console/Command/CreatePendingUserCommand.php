<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Console\Command;

use MsgPhp\Domain\CommandBusInterface;
use MsgPhp\User\Command as UserCommand;
use MsgPhp\User\Infra\Validator\EmailLookupInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreatePendingUserCommand extends Command
{
    protected static $defaultName = 'user:pending:create';

    private $emailLookup;
    private $commandBus;

    public function __construct(EmailLookupInterface $emailLookup, CommandBusInterface $commandBus)
    {
        parent::__construct();

        $this->emailLookup = $emailLookup;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new pending user')
            ->addOption('password', 'p', InputOption::VALUE_OPTIONAL, 'User password (plain text)')
            ->addArgument('email', InputArgument::OPTIONAL, 'User e-mail');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $this->getEmail($io, $input);
        $password = $this->getPassword($io, $input) ?? ($randomPassword = bin2hex(random_bytes(8)));

        $this->commandBus->handle(new UserCommand\CreatePendingUserCommand($email, $password));
        $io->success(sprintf('Pending user "%s" created.', $email));

        if (isset($randomPassword)) {
            $io->warning(['Auto-generated password:', $randomPassword]);
        }

        return 0;
    }

    private function getEmail(StyleInterface $io, InputInterface $input): string
    {
        if ('' === $email = (string) $input->getArgument('email')) {
            if (!$input->isInteractive()) {
                throw new \LogicException('No e-mail provided.');
            }

            do {
                $email = $io->ask('E-mail', null, function ($value) { return $value; });
            } while (null === $email);
        }

        if ($this->emailLookup->exists($email)) {
            throw new \LogicException(sprintf('E-mail "%s" already exists.', $email));
        }

        return $email;
    }

    private function getPassword(StyleInterface $io, InputInterface $input): ?string
    {
        if ('' === $password = (string) $input->getOption('password')) {
            $password = $io->askHidden('Password <comment>(leave empty to generate random value)</comment>', function ($value) { return $value; });
        }

        return $password;
    }
}
