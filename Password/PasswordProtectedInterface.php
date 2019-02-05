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

namespace MsgPhp\User\Password;

/**
 * Represents a password protected resource. The password is usually a *hashed* value (thus secret).
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface PasswordProtectedInterface
{
    public function getPassword(): string;

    public function getPasswordAlgorithm(): PasswordAlgorithm;
}
