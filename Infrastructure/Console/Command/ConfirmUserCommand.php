<?php

declare(strict_types=1);

namespace MsgPhp\User\Infrastructure\Console\Command;

use MsgPhp\User\Command\ConfirmUser;
use MsgPhp\User\Event\UserConfirmed;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ConfirmUserCommand extends UserCommand
{
    protected static $defaultName = 'user:confirm';

    /**
     * @var StyleInterface
     */
    private $io;

    public function onMessageReceived($message): void
    {
        if ($message instanceof UserConfirmed) {
            $this->io->success('Confirmed user '.$message->user->getCredential()->getUsername());
        }
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Confirm a user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $userId = $this->getUser($input, $this->io)->getId();

        $this->dispatch(ConfirmUser::class, compact('userId'));

        return 0;
    }
}
