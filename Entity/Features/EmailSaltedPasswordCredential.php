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

use MsgPhp\User\Entity\Credential\EmailSaltedPassword;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailSaltedPasswordCredential
{
    use AbstractSaltedPasswordCredential;
    use EmailCredential {
        EmailCredential::handleChangeCredentialEvent insteadof AbstractSaltedPasswordCredential;
    }

    /**
     * @var EmailSaltedPassword
     */
    private $credential;

    public function getCredential(): EmailSaltedPassword
    {
        return $this->credential;
    }
}
