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

use MsgPhp\User\Entity\UserEmail;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserEmailConfirmedEvent
{
    /**
     * @var UserEmail
     */
    public $userEmail;

    final public function __construct(UserEmail $userEmail)
    {
        $this->userEmail = $userEmail;
    }
}
