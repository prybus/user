<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\InMemory\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\InMemory\DomainEntityRepositoryTrait;
use MsgPhp\User\Entity\PendingUser;
use MsgPhp\User\Repository\PendingUserRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class PendingUserRepository implements PendingUserRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    private $class = PendingUser::class;
    private $idFields = ['email'];

    /**
     * @return EntityCollectionInterface|PendingUser[]
     */
    public function findAll(int $offset = null, int $limit = null): EntityCollectionInterface
    {
        return $this->createResultSet($offset, $limit);
    }

    public function find(string $email): PendingUser
    {
        return $this->doFind($email);
    }

    public function findByToken(string $token): PendingUser
    {
        return $this->doFindByFields(['token' => $token]);
    }

    public function exists(string $email): bool
    {
        return $this->doExists($email);
    }

    /**
     * @internal
     */
    public function save(PendingUser $user): void
    {
        $this->doSave($user);
    }

    /**
     * @internal
     */
    public function delete(PendingUser $user): void
    {
        $this->doDelete($user);
    }
}
