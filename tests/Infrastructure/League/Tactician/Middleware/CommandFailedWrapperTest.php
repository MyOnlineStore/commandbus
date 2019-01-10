<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Tests\Infrastructure\League\Tactician\Middleware;

use MyOnlineStore\CommandBus\Domain\Exception\CommandFailedException;
use MyOnlineStore\CommandBus\Infrastructure\League\Tactician\Middleware\CommandFailedWrapper;
use PHPUnit\Framework\TestCase;

final class CommandFailedWrapperTest extends TestCase
{
    /**
     * @var CommandFailedWrapper
     */
    private $middleware;

    protected function setUp()
    {
        $this->middleware = new CommandFailedWrapper();
    }

    public function testReturnsNextMiddlewareResultIfNoExceptionOccured()
    {
        $nextMiddleware = static function() {
            return 'foo';
        };

        self::assertEquals('foo', $this->middleware->execute(new \stdClass(), $nextMiddleware));
    }

    public function testWrapsAnyExceptionInCommandFailedException()
    {
        $originalException = new \RuntimeException('To be wrapped', 123);
        $nextMiddleware = static function() use ($originalException) {
            throw $originalException;
        };

        try {
            $this->middleware->execute(new \stdClass(), $nextMiddleware);
            $this->fail();
        } catch (\Throwable $exception) {
            self::assertInstanceOf(CommandFailedException::class, $exception);
            self::assertSame($originalException->getMessage(), $exception->getMessage());
            self::assertSame($originalException->getCode(), $exception->getCode());
            self::assertSame($originalException, $exception->getPrevious());
        }
    }
}
