<?php

declare(strict_types=1);

namespace MsgPhp\User\Event;

use MsgPhp\User\Entity\UserAttributeValue;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserAttributeValueChangedEvent
{
    /** @var UserAttributeValue */
    public $userAttributeValue;

    /** @var mixed */
    public $oldValue;

    public function __construct(UserAttributeValue $userAttributeValue, $oldValue)
    {
        $this->userAttributeValue = $userAttributeValue;
        $this->oldValue = $oldValue;
    }
}
