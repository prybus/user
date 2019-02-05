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

use MsgPhp\User\Password\{PasswordAlgorithm, PasswordHashingInterface};
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface as SymfonyPasswordHashingInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class PasswordHashing implements PasswordHashingInterface
{
    /**
     * @var SymfonyPasswordHashingInterface
     */
    private $hashing;

    public function __construct(SymfonyPasswordHashingInterface $hashing)
    {
        $this->hashing = $hashing;
    }

    public function hash(string $plainPassword, PasswordAlgorithm $algorithm = null): string
    {
        $hash = $this->hashing->encodePassword($plainPassword, self::getSalt($algorithm));

        if (\function_exists('sodium_memzero')) {
            sodium_memzero($plainPassword);
        }

        return $hash;
    }

    public function isValid(string $hashedPassword, string $plainPassword, PasswordAlgorithm $algorithm = null): bool
    {
        $valid = $this->hashing->isPasswordValid($hashedPassword, $plainPassword, self::getSalt($algorithm));

        if (\function_exists('sodium_memzero')) {
            sodium_memzero($plainPassword);
        }

        return $valid;
    }

    private static function getSalt(?PasswordAlgorithm $algorithm): string
    {
        if (null === $algorithm) {
            return '';
        }

        return $algorithm->salt->token ?? '';
    }
}
