<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Model\UserField;
use MsgPhp\User\User;
use MsgPhp\User\UserId;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UserFieldTest extends TestCase
{
    public function testField(): void
    {
        $user = $this->createMock(User::class);
        $user->expects(self::any())
            ->method('getId')
            ->willReturn($this->createMock(UserId::class))
        ;

        $model = new TestUserFieldModel($user);

        self::assertSame($user, $model->getUser());
        self::assertSame($user->getId(), $model->getUserId());
    }
}

class TestUserFieldModel
{
    use UserField;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
