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

namespace MsgPhp\User\Infra\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ExistingUsername extends Constraint
{
    public const DOES_NOT_EXIST_ERROR = '4a8b28f7-a2b5-4435-9dd8-3be5188d23f0';

    /**
     * @var string[]
     */
    protected static $errorNames = [
        self::DOES_NOT_EXIST_ERROR => 'DOES_NOT_EXIST_ERROR',
    ];

    /**
     * @var string
     */
    public $message = 'This value is not valid.';
}
