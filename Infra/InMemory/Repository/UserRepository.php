<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\InMemory\Repository;

use MsgPhp\Domain\Entity\EntityCollectionInterface;
use MsgPhp\Domain\Infra\InMemory\DomainEntityRepositoryTrait;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Repository\UserRepositoryInterface;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserRepository implements UserRepositoryInterface
{
    use DomainEntityRepositoryTrait;

    private $class = User::class;
    private $idFields = ['id'];

    /**
     * @return EntityCollectionInterface|User[]
     */
    public function findAll(int $offset = null, int $limit = null): EntityCollectionInterface
    {
        // @todo remove offset/limit null api here everywhere (imply 0/MAX|INF)
        return $this->createResultSet($offset, $limit);
    }

    public function find(UserIdInterface $id): User
    {
        return $this->doFind($id);
    }

    public function findByEmail(string $email): User
    {
        return $this->doFindByFields(['email' => $email]);
    }

    public function findByPasswordResetToken(string $token): User
    {
        return $this->doFindByFields(['passwordResetToken' => $token]);
    }

    public function exists(UserIdInterface $id): bool
    {
        return $this->doExists($id);
    }

    /**
     * @internal
     */
    public function save(User $user): void
    {
        $this->doSave($user);
    }

    /**
     * @internal
     */
    public function delete(User $user): void
    {
        $this->doDelete($user);
    }
}
