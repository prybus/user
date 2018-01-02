<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\InMemory\Repository;

use MsgPhp\Domain\DomainCollectionInterface;
use MsgPhp\Domain\Infra\InMemory\DomainEntityRepositoryTrait;
use MsgPhp\Eav\{AttributeIdInterface, AttributeValueIdInterface};
use MsgPhp\User\Entity\UserAttributeValue;
use MsgPhp\User\Repository\UserAttributeValueRepositoryInterface;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserAttributeValueRepository implements UserAttributeValueRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    private $idFields = ['userId', 'attributeValueId'];

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeId(AttributeIdInterface $attributeId, int $offset = null, int $limit = null): DomainCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($attributeId) {
            return $userAttributeValue->getAttributeId()->equals($attributeId);
        });
    }

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeIdAndValue(AttributeIdInterface $attributeId, $value, int $offset = null, int $limit = null): DomainCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($attributeId, $value) {
            return $userAttributeValue->getAttributeId()->equals($attributeId) && $value === $userAttributeValue->getValue();
        });
    }

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): DomainCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($userId) {
            return $userAttributeValue->getUserId()->equals($userId);
        });
    }

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserIdAndAttributeId(UserIdInterface $userId, AttributeIdInterface $attributeId, int $offset = null, int $limit = null): DomainCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($userId, $attributeId) {
            return $userAttributeValue->getUserId()->equals($userId) && $userAttributeValue->getAttributeId()->equals($attributeId);
        });
    }

    public function find(UserIdInterface $userId, AttributeValueIdInterface $attributeValueId): UserAttributeValue
    {
        return $this->doFind(...func_get_args());
    }

    public function exists(UserIdInterface $userId, AttributeValueIdInterface $attributeValueId): bool
    {
        return $this->doExists(...func_get_args());
    }

    public function save(UserAttributeValue $userAttributeValue): void
    {
        $this->doSave($userAttributeValue);
    }

    public function delete(UserAttributeValue $userAttributeValue): void
    {
        $this->doDelete($userAttributeValue);
    }
}
