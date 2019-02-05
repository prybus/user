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

namespace MsgPhp\User\Entity\Features;

use MsgPhp\User\Entity\Credential\Features\PasswordWithSaltProtected;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
trait AbstractSaltedPasswordCredential
{
    use AbstractPasswordCredential;

    /**
     * @var PasswordWithSaltProtected
     */
    private $credential;

    public function getPasswordSalt(): string
    {
        return $this->credential->getPasswordSalt();
    }

    public function changePasswordSalt(string $passwordSalt): void
    {
        $this->credential = $this->credential->withPasswordSalt($passwordSalt);
    }
}
