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

use MsgPhp\User\Entity\Credential\Token;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait TokenCredential
{
    use AbstractCredential;

    /**
     * @var Token
     */
    private $credential;

    public function getCredential(): Token
    {
        return $this->credential;
    }

    public function getToken(): string
    {
        return $this->credential->getToken();
    }

    public function changeToken(string $token): void
    {
        $this->credential = $this->credential->withToken($token);
    }
}
