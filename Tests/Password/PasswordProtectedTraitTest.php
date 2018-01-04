<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Password;

use MsgPhp\User\Password\{PasswordAlgorithm, PasswordProtectedTrait};
use PHPUnit\Framework\TestCase;

final class PasswordProtectedTraitTest extends TestCase
{
    public function testObject(): void
    {
        $object = $this->getObject('pass');

        $this->assertSame('pass', $object->getPassword());
        $this->assertEquals(PasswordAlgorithm::create(), $object->createPasswordAlgorithm());
    }

    private function getObject($password)
    {
        return new class($password) {
            use PasswordProtectedTrait;

            public function __construct($password)
            {
                $this->password = $password;
            }
        };
    }
}
