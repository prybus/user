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
final class UniqueUsername extends Constraint
{
    public const IS_NOT_UNIQUE_ERROR = '37c4ba30-07ae-48e5-9767-19764e027346';

    /**
     * @var string[]
     */
    protected static $errorNames = [
        self::IS_NOT_UNIQUE_ERROR => 'IS_NOT_UNIQUE_ERROR',
    ];

    /**
     * @var string
     */
    public $message = 'This value is not valid.';
}
