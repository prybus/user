<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\PendingUser;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class PendingUserCreatedEvent
{
    public $pendingUser;

    public function __construct(PendingUser $pendingUser)
    {
        $this->pendingUser = $pendingUser;
    }
}
