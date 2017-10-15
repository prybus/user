<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Infra\Security;

use MsgPhp\User\Infra\PHPUnit\UserEntityTrait;
use MsgPhp\User\Infra\Security\SecurityUser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityUserTest extends TestCase
{
    use UserEntityTrait;

    public function testCreateNewSecurityUser()
    {
        $user = $this->createUser('foo@bar.baz');
        $securityUser = new SecurityUser($user);

        $this->assertTrue($user->getId()->equals($securityUser->getId()));
        $this->assertSame($user->getEmail(), $securityUser->getUsername());
        $this->assertSame($user->getPassword(), $securityUser->getPassword());
    }

    public function testIsEqualTo()
    {
        $user = $this->createUser('foo@bar.baz', 'secret');
        $securityUser = new SecurityUser($user);

        $this->assertTrue($securityUser->isEqualTo(new SecurityUser($user)));
        $this->assertTrue($securityUser->isEqualTo(new SecurityUser($this->createUser('foo@bar.baz', 'secret', $user->getId()->toString()))));
        $this->assertFalse($securityUser->isEqualTo(new SecurityUser($this->createUser('foo@bar.baz', 'other', $user->getId()->toString()))));
        $this->assertFalse($securityUser->isEqualTo(new SecurityUser($this->createUser('other', 'secret', $user->getId()->toString()))));
        $this->assertFalse($securityUser->isEqualTo(new SecurityUser($this->createUser('foo@bar.baz', 'secret'))));
        $this->assertFalse($securityUser->isEqualTo($this->getMockBuilder(UserInterface::class)->getMock()));
    }

    public function testSerialize()
    {
        $user = $this->createUser('foo@bar.baz');

        $this->assertTrue(($serialized = serialize(new SecurityUser($user))) === serialize(unserialize($serialized)));
    }
}
