<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Tests\Domain\Exception;

use MyOnlineStore\CommandBus\Domain\Exception\CommandFailedException;
use PHPUnit\Framework\TestCase;

final class CommandFailedExceptionTest extends TestCase
{
    public function testWrap()
    {
        $command = new \stdClass();
        $exception = new \Exception('Error', 123);

        $commandFailedException = CommandFailedException::wrap($exception, $command);

        self::assertSame($exception->getMessage(), $commandFailedException->getMessage());
        self::assertSame($exception->getCode(), $commandFailedException->getCode());
        self::assertSame($exception, $commandFailedException->getPrevious());
        self::assertSame($command, $commandFailedException->getFailedCommand());
    }

    public function testWrapDoesNotReWrapCommandFailedExceptions()
    {
        $exception = new CommandFailedException('command failed');
        $commandFailedException = CommandFailedException::wrap($exception, new \stdClass());

        self::assertSame($exception, $commandFailedException);
    }
}
