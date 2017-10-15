<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\Domain\Entity\CreatedAtFieldTrait;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @final
 */
class PendingUser
{
    use CreatedAtFieldTrait;

    private $token;
    private $email;
    private $password;

    /**
     * @internal
     */
    public function __construct(string $email, string $password)
    {
        $this->token = bin2hex(random_bytes(32));
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new \DateTime();
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
