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

namespace MsgPhp\User\Infra\Security;

use MsgPhp\User\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserArgumentValueResolver implements ArgumentValueResolverInterface
{
    use TokenStorageAwareTrait;

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_a($argument->getType(), User::class, true) ? ($argument->isNullable() || $this->isUser()) : false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->toUser();
    }
}
