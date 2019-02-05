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

use MsgPhp\User\Entity\Credential\Features\PasswordProtected;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
trait AbstractPasswordCredential
{
    use AbstractCredential;

    /**
     * @var PasswordProtected
     */
    private $credential;

    public function getPassword(): string
    {
        return $this->credential->getPassword();
    }

    public function changePassword(string $password): void
    {
        $this->credential = $this->credential->withPassword($password);
    }
}
