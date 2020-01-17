<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Domain\Exception;

final class CommandFailedException extends \RuntimeException
{
    public static function wrap(\Throwable $previous): self
    {
        return new self($previous->getMessage(), $previous->getCode(), $previous);
    }
}
