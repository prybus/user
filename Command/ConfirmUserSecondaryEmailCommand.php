<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ConfirmUserSecondaryEmailCommand
{
    /** @var string */
    public $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
