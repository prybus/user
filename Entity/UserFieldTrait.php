<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait UserFieldTrait
{
    private $user;

    public function getUser(): User
    {
        if (null === $this->user) {
            throw new \LogicException('User is not set.');
        }

        return $this->user;
    }

    public function getUserId(): UserIdInterface
    {
        return $this->getUser()->getId();
    }
}
