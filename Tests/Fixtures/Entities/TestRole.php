<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Fixtures\Entities;

use MsgPhp\User\Role;

/**
 * @Doctrine\ORM\Mapping\Entity()
 */
class TestRole extends Role
{
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Id()
     * @Doctrine\ORM\Mapping\Column()
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
