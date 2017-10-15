<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Doctrine\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\Doctrine\DomainEntityRepositoryTrait;
use MsgPhp\User\Entity\UserRole;
use MsgPhp\User\Repository\UserRoleRepositoryInterface;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserRoleRepository implements UserRoleRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    private $class = UserRole::class;
    private $alias = 'user_role';
    private $idFields = ['user', 'role'];

    /**
     * @return EntityCollectionInterface|UserRole[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        $qb = $this->createQueryBuilder($offset, $limit);
        $this->addFieldCriteria($qb, ['user' => $userId]);

        return $this->createResultSet($qb->getQuery());
    }

    public function find(UserIdInterface $userId, string $role): UserRole
    {
        return $this->doFind(...func_get_args());
    }

    public function exists(UserIdInterface $userId, string $role): bool
    {
        return $this->doExists(...func_get_args());
    }

    /**
     * @internal
     */
    public function save(UserRole $userRole): void
    {
        $this->doSave($userRole);
    }

    /**
     * @internal
     */
    public function delete(UserRole $userRole): void
    {
        $this->doDelete($userRole);
    }
}
