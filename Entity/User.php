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

namespace MsgPhp\User\Entity;

use MsgPhp\User\{CredentialInterface, UserIdInterface};
use MsgPhp\User\Entity\Credential\Anonymous;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
abstract class User
{
    abstract public function getId(): UserIdInterface;

    /**
     * @return CredentialInterface
     */
    public function getCredential()
    {
        return new Anonymous();
    }
}
