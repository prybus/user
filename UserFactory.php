<?php

declare(strict_types=1);

namespace MsgPhp\User;

use MsgPhp\Eav\Entity\Attribute;
use MsgPhp\User\Entity\{
    PendingUser, User, UserAttributeValue, UserRole, UserSecondaryEmail
};
use MsgPhp\User\Infra\Uuid\UserId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserFactory
{
    private $classMapping;
    private $passwordEncoder;

    public function __construct(array $classMapping, PasswordEncoderInterface $passwordEncoder)
    {
        $this->classMapping = $classMapping;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUserId($id = null): UserIdInterface
    {
        $class = $this->classMapping[UserIdInterface::class] ?? UserId::class;

        return new $class($id);
    }

    public function createPendingUser(string $email, string $password, bool $plainPassword = true): PendingUser
    {
        $class = $this->classMapping[PendingUser::class] ?? PendingUser::class;

        return new $class($email, $plainPassword ? $this->passwordEncoder->encode($password) : $password);
    }

    public function createUser(string $email, string $password, bool $plainPassword = true): User
    {
        return $this->createIdentifiedUser($this->createUserId(), $email, $password, $plainPassword);
    }

    public function createIdentifiedUser(UserIdInterface $id, string $email, string $password, bool $plainPassword = true): User
    {
        $class = $this->classMapping[User::class] ?? User::class;

        return new $class($id, $email, $plainPassword ? $this->passwordEncoder->encode($password) : $password);
    }

    public function createUserRole(User $user, string $role): UserRole
    {
        $class = $this->classMapping[UserRole::class] ?? UserRole::class;

        return new $class($user, $role);
    }

    public function createUserSecondaryEmail(User $user, string $email): UserSecondaryEmail
    {
        $class = $this->classMapping[UserSecondaryEmail::class] ?? UserSecondaryEmail::class;

        return new $class($user, $email);
    }

    public function createUserAttributeValue(User $user, Attribute $attribute, $value): UserAttributeValue
    {
        $class = $this->classMapping[UserAttributeValue::class] ?? UserAttributeValue::class;

        return new $class($user, $attribute, $value);
    }
}
