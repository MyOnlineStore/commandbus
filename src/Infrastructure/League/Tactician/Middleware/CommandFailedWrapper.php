<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Infrastructure\League\Tactician\Middleware;

use League\Tactician\Middleware;
use MyOnlineStore\CommandBus\Domain\Exception\CommandFailedException;

/**
 * Wrap any thrown exception in a CommandFailedException
 */
final class CommandFailedWrapper implements Middleware
{
    /**
     * @param object   $command
     * @param callable $next
     *
     * @return mixed
     *
     * @throws CommandFailedException
     */
    public function execute($command, callable $next)
    {
        try {
            return $next($command);
        } catch (\Throwable $exception) {
            throw CommandFailedException::wrap($exception, $command);
        }
    }
}
