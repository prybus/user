<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserCreatedEvent
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var array
     */
    public $context;

    final public function __construct(User $user, array $context)
    {
        $this->user = $user;
        $this->context = $context;
    }
}
