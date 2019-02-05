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

use MsgPhp\User\Entity\Credential\NicknameSaltedPassword;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait NicknameSaltedPasswordCredential
{
    use AbstractSaltedPasswordCredential;
    use NicknameCredential {
        NicknameCredential::handleChangeCredentialEvent insteadof AbstractSaltedPasswordCredential;
    }

    /**
     * @var NicknameSaltedPassword
     */
    private $credential;

    public function getCredential(): NicknameSaltedPassword
    {
        return $this->credential;
    }
}
