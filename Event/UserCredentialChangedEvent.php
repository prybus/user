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

namespace MsgPhp\User\Event;

use MsgPhp\User\CredentialInterface;
use MsgPhp\User\Entity\User;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserCredentialChangedEvent
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var CredentialInterface
     */
    public $oldCredential;

    /**
     * @var CredentialInterface
     */
    public $newCredential;

    final public function __construct(User $user, CredentialInterface $oldCredential, CredentialInterface $newCredential)
    {
        $this->user = $user;
        $this->oldCredential = $oldCredential;
        $this->newCredential = $newCredential;
    }
}
