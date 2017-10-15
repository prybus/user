<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ResetUserPasswordCommand
{
    /** @var string */
    public $token;

    /** @var string */
    public $password;

    public function __construct(string $token, string $password)
    {
        $this->token = $token;
        $this->password = $password;
    }
}
