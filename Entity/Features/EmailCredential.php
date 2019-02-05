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

use MsgPhp\User\Entity\Credential\Email;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailCredential
{
    use AbstractCredential;

    /**
     * @var Email
     */
    private $credential;

    public function getCredential(): Email
    {
        return $this->credential;
    }

    public function getEmail(): string
    {
        return $this->credential->getEmail();
    }

    public function changeEmail(string $email): void
    {
        $this->credential = $this->credential->withEmail($email);
    }
}
