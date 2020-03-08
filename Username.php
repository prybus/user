<?php

declare(strict_types=1);

namespace MsgPhp\User;

use MsgPhp\User\Model\UserField;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template T of User
 */
abstract class Username
{
    /** @use UserField<T> */
    use UserField;

    /** @var string */
    private $username;

    /**
     * @param T $user
     */
    public function __construct(User $user, string $username)
    {
        $this->user = $user;
        $this->username = $username;
    }

    public function toString(): string
    {
        return $this->username;
    }
}
