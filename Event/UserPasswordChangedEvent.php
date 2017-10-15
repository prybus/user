<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserPasswordChangedEvent
{
    /** @var User */
    public $user;

    /** @var string */
    public $oldPassword;

    public function __construct(User $user, string $oldPassword)
    {
        $this->user = $user;
        $this->oldPassword = $oldPassword;
    }
}
