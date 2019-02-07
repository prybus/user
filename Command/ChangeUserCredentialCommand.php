<?php

declare(strict_types=1);

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
