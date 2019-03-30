<?php

declare(strict_types=1);

namespace MsgPhp\User\Model;

use MsgPhp\User\Credential\EmailPassword;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailPasswordCredential
{
    use AbstractPasswordCredential;
    use EmailCredential {
        EmailCredential::onChangeCredentialEvent insteadof AbstractPasswordCredential;
    }

    /**
     * @var EmailPassword
     */
    private $credential;

    public function getCredential(): EmailPassword
    {
        return $this->credential;
    }
}
