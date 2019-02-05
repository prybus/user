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

namespace MsgPhp\User\Command;

use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class RequestUserPasswordCommand
{
    /**
     * @var UserIdInterface
     */
    public $userId;

    /**
     * @var string|null
     */
    public $token;

    final public function __construct(UserIdInterface $userId, string $token = null)
    {
        $this->userId = $userId;
        $this->token = $token;
    }
}
