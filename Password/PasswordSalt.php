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

namespace MsgPhp\User\Password;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class PasswordSalt
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var int
     */
    public $iterations;

    /**
     * @var string
     */
    public $format;

    public function __construct(string $token, int $iterations = 5000, string $format = '%s{%s}')
    {
        $this->token = $token;
        $this->iterations = $iterations;
        $this->format = $format;
    }
}
