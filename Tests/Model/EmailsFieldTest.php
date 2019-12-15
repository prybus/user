<?php

declare(strict_types=1);

namespace MsgPhp\User\Tests\Model;

use MsgPhp\User\Model\EmailsField;
use MsgPhp\User\UserEmail;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EmailsFieldTest extends TestCase
{
    public function testField(): void
    {
        self::assertSame($emails = [$this->createMock(UserEmail::class)], iterator_to_array((new TestEmailsFieldModel($emails))->getEmails()));
    }
}

class TestEmailsFieldModel
{
    use EmailsField;

    /**
     * @param iterable<array-key, UserEmail> $emails
     */
    public function __construct(iterable $emails)
    {
        $this->emails = $emails;
    }
}
