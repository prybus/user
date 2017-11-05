<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Doctrine\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\Doctrine\DomainEntityRepositoryTrait;
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

    private $alias = 'user_attribute_value';
    private $idFields = ['user', 'attributeValue'];

    /**
     * @return EntityCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeId(AttributeIdInterface $attributeId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        $qb = $this->createQueryBuilder($offset, $limit);
        $this->addFieldCriteria($qb, ['attributeValue.attribute' => $attributeId]);

        return $this->createResultSet($qb->getQuery());
    }

    /**
     * @return EntityCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        $qb = $this->createQueryBuilder($offset, $limit);
        $this->addFieldCriteria($qb, ['user' => $userId]);

        return $this->createResultSet($qb->getQuery());
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
