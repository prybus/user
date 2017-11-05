<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\InMemory\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
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
     * @return EntityCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeId(AttributeIdInterface $attributeId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($attributeId) {
            return $userAttributeValue->getAttributeId()->equals($attributeId);
        });
    }

    /**
     * @return EntityCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeIdAndValue(AttributeIdInterface $attributeId, $value, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($attributeId, $value) {
            return $userAttributeValue->getAttributeId()->equals($attributeId) && $value === $userAttributeValue->getValue();
        });
    }

    /**
     * @return EntityCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserAttributeValue $userAttributeValue) use ($userId) {
            return $userAttributeValue->getUserId()->equals($userId);
        });
    }

    /**
     * @return EntityCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserIdAndAttributeId(UserIdInterface $userId, AttributeIdInterface $attributeId, int $offset = null, int $limit = null): EntityCollectionInterface
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

    /**
     * @internal
     */
    public function save(UserAttributeValue $userAttributeValue): void
    {
        $this->doSave($userAttributeValue);
    }

    /**
     * @internal
     */
    public function delete(UserAttributeValue $userAttributeValue): void
    {
        $this->doDelete($userAttributeValue);
    }
}
