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

use MsgPhp\User\Entity\Credential\Nickname;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait NicknameCredential
{
    use AbstractCredential;

    /**
     * @var Nickname
     */
    private $credential;

    public function getCredential(): Nickname
    {
        return $this->credential;
    }

    public function getNickname(): string
    {
        return $this->credential->getNickname();
    }

    public function changeNickname(string $nickname): void
    {
        $this->credential = $this->credential->withNickname($nickname);
    }
}
