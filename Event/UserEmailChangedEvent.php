<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserEmailChangedEvent
{
    /** @var User */
    public $user;

    /** @var string */
    public $oldEmail;

    public function __construct(User $user, string $oldEmail)
    {
        $this->user = $user;
        $this->oldEmail = $oldEmail;
    }
}
