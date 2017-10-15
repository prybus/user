<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Security;

use MsgPhp\User\Entity\User;
use MsgPhp\User\UserIdInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class SecurityUser implements UserInterface, EquatableInterface, \Serializable
{
    private $id;
    private $email;
    private $password;
    private $roles;

    public function __construct(User $user, array $roles = [])
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->roles = $roles;
    }

    public function getId(): UserIdInterface
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user instanceof self
            && $this->getId()->equals($user->getId())
            && $this->getRoles() === $user->getRoles()
            && $this->getPassword() === $user->getPassword()
            && $this->getUsername() === $user->getUsername()
            && $this->getSalt() === $user->getSalt();
    }

    public function serialize(): string
    {
        return serialize([$this->id, $this->email, $this->password, $this->roles]);
    }

    public function unserialize(/*string */$serialized): void
    {
        list($this->id, $this->email, $this->password, $this->roles) = unserialize($serialized);
    }
}
