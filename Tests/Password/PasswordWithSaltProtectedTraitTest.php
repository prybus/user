<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Password;

use MsgPhp\User\Password\{
    PasswordAlgorithm, PasswordSalt, PasswordWithSaltProtectedTrait
};
use PHPUnit\Framework\TestCase;

final class PasswordWithSaltProtectedTraitTest extends TestCase
{
    public function testObject(): void
    {
        $object = $this->getObject('salt');

        $this->assertSame('salt', $object->getPasswordSalt());
        $this->assertEquals(PasswordAlgorithm::createLegacySalted(new PasswordSalt('salt')), $object->createPasswordAlgorithm());
    }

    private function getObject($salt)
    {
        return new class($salt) {
            use PasswordWithSaltProtectedTrait;

            public function __construct($salt)
            {
                $this->passwordSalt = $salt;
            }
        };
    }
}
