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

use MsgPhp\User\Entity\Credential\NicknamePassword;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait NicknamePasswordCredential
{
    use AbstractPasswordCredential;
    use NicknameCredential {
        NicknameCredential::handleChangeCredentialEvent insteadof AbstractPasswordCredential;
    }

    /**
     * @var NicknamePassword
     */
    private $credential;

    public function getCredential(): NicknamePassword
    {
        return $this->credential;
    }
}
