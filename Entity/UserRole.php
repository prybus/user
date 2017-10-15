<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\Domain\Entity\CreatedAtFieldTrait;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @final
 */
class UserRole
{
    use CreatedAtFieldTrait;

    private $user;
    private $role;

    /**
     * @internal
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->createdAt = new \DateTime();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): UserIdInterface
    {
        return $this->user->getId();
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
