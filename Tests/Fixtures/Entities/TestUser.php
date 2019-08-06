<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Fixtures\Entities;

use MsgPhp\User\ScalarUserId;
use MsgPhp\User\User;
use MsgPhp\User\UserId;

/**
 * @Doctrine\ORM\Mapping\Entity()
 */
class TestUser extends User
{
    /**
     * @var UserId
     * @Doctrine\ORM\Mapping\Id()
     * @Doctrine\ORM\Mapping\GeneratedValue()
     * @Doctrine\ORM\Mapping\Column(type="msgphp_user_id")
     */
    private $id;

    public function __construct(UserId $id = null)
    {
        $this->id = $id ?? new ScalarUserId();
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}
