<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Tests\Domain\Exception;

use MyOnlineStore\CommandBus\Domain\Exception\CommandFailedException;
use PHPUnit\Framework\TestCase;

final class CommandFailedExceptionTest extends TestCase
{
    public function testWrap(): void
    {
        $commandFailed = CommandFailedException::wrap(
            $previous = new \Exception('Foobar', 234)
        );

        self::assertSame($previous->getMessage(), $commandFailed->getMessage());
        self::assertSame($previous->getCode(), $commandFailed->getCode());
        self::assertSame($previous, $commandFailed->getPrevious());
    }
}
