<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\PendingUser;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class PendingUserConfirmedEvent
{
    public $pendingUser;
    public $userId;

    public function __construct(PendingUser $pendingUser, UserIdInterface $userId)
    {
        $this->pendingUser = $pendingUser;
        $this->userId = $userId;
    }
}
