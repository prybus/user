<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Security;

use MsgPhp\User\Entity\User;
use MsgPhp\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
trait TokenStorageAwareTrait
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    public function __construct(TokenStorageInterface $tokenStorage, UserRepositoryInterface $repository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->repository = $repository;
    }

    private function isUser(): bool
    {
        $token = $this->tokenStorage->getToken();

        return null !== $token && $token->getUser() instanceof SecurityUser;
    }

    private function toUser(): ?User
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return null;
        }

        $user = $token->getUser();

        if (!$user instanceof SecurityUser) {
            return null;
        }

        return $this->repository->find($user->getUserId());
    }
}
