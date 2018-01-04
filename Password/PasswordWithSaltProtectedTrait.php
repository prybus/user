<?php

declare(strict_types=1);

namespace MsgPhp\User\Password;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait PasswordWithSaltProtectedTrait
{
    use PasswordProtectedTrait;

    /** @var string */
    private $passwordSalt;

    public function getPasswordSalt(): string
    {
        return $this->passwordSalt;
    }

    public function createPasswordAlgorithm(): PasswordAlgorithm
    {
        return PasswordAlgorithm::createLegacySalted(new PasswordSalt($this->passwordSalt));
    }
}
