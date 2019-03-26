<?php

declare(strict_types=1);

namespace MsgPhp\User\Event\Domain;

use MsgPhp\Domain\Event\DomainEvent;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ChangeCredential implements DomainEvent
{
    /**
     * @var array
     */
    public $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
}
