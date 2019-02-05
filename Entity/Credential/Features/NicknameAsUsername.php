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

namespace MsgPhp\User\Entity\Credential\Features;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait NicknameAsUsername
{
    /**
     * @var string
     */
    private $nickname;

    public static function getUsernameField(): string
    {
        return 'nickname';
    }

    public function getUsername(): string
    {
        return $this->nickname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    abstract public function withNickname(string $nickname): self;
}
