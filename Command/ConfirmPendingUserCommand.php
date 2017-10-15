<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ConfirmPendingUserCommand
{
    /** @var string */
    public $token;

    /** @var UserIdInterface */
    public $userId;

    /** @var bool */
    public $enableUser;

    public function __construct(string $token, UserIdInterface $userId, bool $enableUser = true)
    {
        $this->token = $token;
        $this->userId = $userId;
        $this->enableUser = $enableUser;
    }
}
