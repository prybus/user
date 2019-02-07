<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class AddUserEmailCommand
{
    /**
     * @var UserIdInterface
     */
    public $userId;

    /**
     * @var string
     */
    public $email;

    /**
     * @var array
     */
    public $context;

    final public function __construct(UserIdInterface $userId, string $email, array $context = [])
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->context = $context;
    }
}
