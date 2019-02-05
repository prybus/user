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

namespace MsgPhp\User\Entity\Credential;

use MsgPhp\User\CredentialInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class Token implements CredentialInterface
{
    /**
     * @var string
     */
    private $token;

    public static function getUsernameField(): string
    {
        return 'token';
    }

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getUsername(): string
    {
        return $this->token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function withToken(string $token): self
    {
        return new self($token);
    }
}
