<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity;

use MsgPhp\Domain\Entity\CreatedAtFieldTrait;
use MsgPhp\Eav\Entity\AttributeValue;
use MsgPhp\Eav\Entity\AttributeValueFieldTrait;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class UserAttributeValue
{
    use CreatedAtFieldTrait;
    use UserFieldTrait;
    use AttributeValueFieldTrait;

    public function __construct(User $user, AttributeValue $attributeValue)
    {
        $this->user = $user;
        $this->attributeValue = $attributeValue;
        $this->createdAt = new \DateTimeImmutable();
    }
}
