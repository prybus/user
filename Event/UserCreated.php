<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserCreated
{
    public $user;
    public $context;

    public function __construct(User $user, array $context)
    {
        $this->user = $user;
        $this->context = $context;
    }
}
