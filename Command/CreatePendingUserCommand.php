<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class CreatePendingUserCommand
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var bool */
    public $plainPassword;

    /** @var array */
    public $context;

    public function __construct(string $email, string $password, bool $plainPassword = true, array $context = [])
    {
        $this->email = $email;
        $this->password = $password;
        $this->plainPassword = $plainPassword;
        $this->context = $context;
    }
}
