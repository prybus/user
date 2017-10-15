<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\Domain\Entity\CreatedAtFieldTrait;
use MsgPhp\Domain\Entity\LastUpdatedAtFieldTrait;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @final
 */
class User
{
    use CreatedAtFieldTrait;
    use LastUpdatedAtFieldTrait;

    private $id;
    private $email;
    private $password;
    private $passwordResetToken;
    private $passwordRequestedAt;
    private $enabled = false;

    /**
     * @internal
     */
    public function __construct(UserIdInterface $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new \DateTime();
        $this->lastUpdatedAt = new \DateTime();
    }

    public function getId(): UserIdInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function getPasswordRequestedAt(): ?\DateTime
    {
        return $this->passwordRequestedAt;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @internal
     */
    public function changeEmail(string $email): void
    {
        $this->email = $email;
        $this->lastUpdatedAt = new \DateTime();
    }

    /**
     * @internal
     */
    public function changePassword(string $password): void
    {
        $this->password = $password;
        $this->passwordResetToken = null;
        $this->passwordRequestedAt = null;
        $this->lastUpdatedAt = new \DateTime();
    }

    /**
     * @internal
     */
    public function requestPassword(): void
    {
        $this->passwordResetToken = bin2hex(random_bytes(32));
        $this->passwordRequestedAt = new \DateTime();
        $this->lastUpdatedAt = new \DateTime();
    }

    /**
     * @internal
     */
    public function enable()
    {
        $this->enabled = true;
        $this->lastUpdatedAt = new \DateTime();
    }

    /**
     * @internal
     */
    public function disable()
    {
        $this->enabled = false;
        $this->lastUpdatedAt = new \DateTime();
    }
}
