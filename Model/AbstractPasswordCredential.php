<?php

declare(strict_types=1);

namespace MsgPhp\User\Model;

use MsgPhp\User\Credential\PasswordProtectedCredential;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait AbstractPasswordCredential
{
    use AbstractCredential;

    /**
     * @var PasswordProtectedCredential
     */
    private $credential;

    public function getPassword(): string
    {
        return $this->credential->getPassword();
    }
}
