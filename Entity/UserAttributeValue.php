<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\Eav\AttributeValueIdInterface;
use MsgPhp\Eav\Entity\Attribute;
use MsgPhp\Eav\Entity\AttributeValue;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserAttributeValue extends AttributeValue
{
    use UserFieldTrait;

    /**
     * @internal
     */
    public function __construct(AttributeValueIdInterface $id, User $user, Attribute $attribute, $value)
    {
        parent::__construct($id, $attribute, $value);

        $this->user = $user;
    }
}
