<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\User\Entity\Credential\Features;

use MsgPhp\User\Password\{PasswordAlgorithm, PasswordSalt};

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait PasswordWithSaltProtected
{
    use PasswordProtected;

    /**
     * @var string
     */
    private $passwordSalt;

    public function getPasswordSalt(): string
    {
        return $this->passwordSalt;
    }

    public function getPasswordAlgorithm(): PasswordAlgorithm
    {
        return PasswordAlgorithm::createLegacySalted(new PasswordSalt($this->passwordSalt));
    }

    abstract public function withPasswordSalt(string $passwordSalt): self;
}
