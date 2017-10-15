<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\InMemory\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\InMemory\DomainEntityRepositoryTrait;
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
    private $idFields = ['userId', 'email'];

    /**
     * @return EntityCollectionInterface|UserSecondaryEmail[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): EntityCollectionInterface
    {
        return $this->createResultSet($offset, $limit, function (UserSecondaryEmail $userSecondaryEmail) use ($userId) {
            return $userSecondaryEmail->getUserId()->equals($userId);
        });
    }

    public function find(UserIdInterface $userId, string $email): UserSecondaryEmail
    {
        return $this->doFind(...func_get_args());
    }

    public function findPendingPrimary(UserIdInterface $userId): UserSecondaryEmail
    {
        return $this->doFindByFields(['userId' => $userId, 'pendingPrimary' => true]);
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
