<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class AddUserSecondaryEmailCommand
{
    /** @var UserIdInterface */
    public $userId;

    /** @var string */
    public $email;

    /** @var bool */
    public $confirm;

    /** @var array */
    public $context;

    public function __construct(UserIdInterface $userId, string $email, bool $confirm = false, array $context = [])
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->confirm = $confirm;
        $this->context = $context;
    }
}
