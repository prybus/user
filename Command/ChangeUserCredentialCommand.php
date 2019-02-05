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
class ChangeUserCredentialCommand
{
    /**
     * @var UserIdInterface
     */
    public $userId;

    /**
     * @var array
     */
    public $fields;

    final public function __construct(UserIdInterface $userId, array $fields)
    {
        $this->userId = $userId;
        $this->fields = $fields;
    }
}
