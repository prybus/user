<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Doctrine\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\Doctrine\DomainEntityRepositoryTrait;
use MsgPhp\User\Entity\UserSecondaryEmail;
use MsgPhp\User\Repository\UserSecondaryEmailRepositoryInterface;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserSecondaryEmailRepository implements UserSecondaryEmailRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    private $class = UserSecondaryEmail::class;
    private $alias = 'user_secondary_email';
    private $idFields = ['user', 'email'];

    /**
     * @return EntityCollectionInterface|UserSecondaryEmail[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        $qb = $this->createQueryBuilder($offset, $limit);
        $this->addFieldCriteria($qb, ['user' => $userId]);

        return $this->createResultSet($qb->getQuery());
    }

    public function find(UserIdInterface $userId, string $email): UserSecondaryEmail
    {
        return $this->doFind(...func_get_args());
    }

    public function findPendingPrimary(UserIdInterface $userId): UserSecondaryEmail
    {
        return $this->doFindByFields(['user' => $userId, 'pendingPrimary' => true]);
    }

    public function findByEmail(string $email): UserSecondaryEmail
    {
        return $this->doFindByFields(['email' => $email]);
    }

    public function findByToken(string $token): UserSecondaryEmail
    {
        return $this->doFindByFields(['token' => $token]);
    }

    public function exists(UserIdInterface $userId, string $email): bool
    {
        return $this->doExists(...func_get_args());
    }

    /**
     * @internal
     */
    public function save(UserSecondaryEmail $userSecondaryEmail): void
    {
        $this->doSave($userSecondaryEmail);
    }

    /**
     * @internal
     */
    public function delete(UserSecondaryEmail $userSecondaryEmail): void
    {
        $this->doDelete($userSecondaryEmail);
    }
}
