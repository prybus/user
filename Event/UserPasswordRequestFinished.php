<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Credential\Credential;
use MsgPhp\User\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserPasswordRequestFinished
{
    public $user;
    public $oldCredential;

    public function __construct(User $user, Credential $oldCredential)
    {
        $this->user = $user;
        $this->oldCredential = $oldCredential;
    }
}
