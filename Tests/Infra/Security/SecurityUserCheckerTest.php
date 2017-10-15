<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Infra\Security;

use MsgPhp\Domain\Exception\EntityNotFoundException;
use MsgPhp\User\Infra\InMemory\Repository\UserRepository;
use MsgPhp\User\Infra\PHPUnit\UserEntityTrait;
use MsgPhp\User\Infra\Security\SecurityUser;
use MsgPhp\User\Infra\Security\SecurityUserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityUserCheckerTest extends TestCase
{
    use UserEntityTrait;

    public function testPreAuth()
    {
        $checker = new SecurityUserChecker(new UserRepository([$user = $this->createUser('foo@bar.baz')]));

        try {
            $checker->checkPreAuth($securityUser = new SecurityUser($user));

            $this->fail();
        } catch (DisabledException $e) {
            $this->assertTrue(true);
        }

        $user->enable();

        try {
            $checker->checkPreAuth($securityUser);

            $this->assertTrue(true);
        } catch (\Throwable $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testPreAuthWithUnknownUser()
    {
        $this->expectException(EntityNotFoundException::class);

        (new SecurityUserChecker(new UserRepository([])))
            ->checkPreAuth(new SecurityUser($this->createUser('foo@bar.baz')));
    }

    public function testPreAuthWithUnsupportedUser()
    {
        try {
            (new SecurityUserChecker(new UserRepository([])))
                ->checkPreAuth($this->getMockBuilder(UserInterface::class)->getMock());

            $this->assertTrue(true);
        } catch (\Throwable $e) {
            $this->fail($e->getMessage());
        }
    }
}
