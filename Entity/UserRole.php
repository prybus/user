<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\Domain\Entity\CreatedAtFieldTrait;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserRole
{
    use CreatedAtFieldTrait;
    use UserFieldTrait;

    private $role;

    /**
     * @internal
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
