<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Domain\Exception;

final class CommandFailedException extends \RuntimeException
{
    /**
     * @var object|null
     */
    private $failedCommand;

    /**
     * @param \Throwable $dispatchException
     * @param object     $command
     *
     * @return CommandFailedException
     */
    public static function wrap(\Throwable $dispatchException, $command): self
    {
        if ($dispatchException instanceof self) {
            return $dispatchException;
        }

        $exception = new static($dispatchException->getMessage(), $dispatchException->getCode(), $dispatchException);
        $exception->failedCommand = $command;

        return $exception;
    }

    public function getFailedCommand()
    {
        return $this->failedCommand;
    }
}
