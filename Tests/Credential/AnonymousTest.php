<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Credential;

use MsgPhp\User\Credential\Anonymous;
use MsgPhp\User\Event\Domain\ChangeCredential;
use PHPUnit\Framework\TestCase;

final class AnonymousTest extends TestCase
{
    public function testInvoke(): void
    {
        $credential = new Anonymous();
        $event = new ChangeCredential(['foo' => 'bar']);

        $this->expectException(\BadMethodCallException::class);

        $credential($event);
    }
}
