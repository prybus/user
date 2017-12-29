<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\InMemory\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\InMemory\DomainEntityRepositoryTrait;
use MsgPhp\User\Entity\UserRole;
use MsgPhp\User\Repository\UserRoleRepositoryInterface;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserRoleRepository implements UserRoleRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    private $idFields = ['userId', 'role'];

    /**
     * @return EntityCollectionInterface|UserRole[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserRole $userRole) use ($userId) {
            return $userRole->getUserId()->equals($userId);
        });
    }

    public function find(UserIdInterface $userId, string $role): UserRole
    {
        return $this->doFind(...func_get_args());
    }

    public function exists(UserIdInterface $userId, string $role): bool
    {
        return $this->doExists(...func_get_args());
    }

    public function save(UserRole $userRole): void
    {
        $this->doSave($userRole);
    }

    public function delete(UserRole $userRole): void
    {
        $this->doDelete($userRole);
    }
}
