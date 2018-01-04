<?php

declare(strict_types=1);

namespace MsgPhp\User\Password;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait PasswordProtectedTrait
{
    /** @var string */
    private $password;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function createPasswordAlgorithm(): PasswordAlgorithm
    {
        return PasswordAlgorithm::create();
    }
}
