<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Application;

use MyOnlineStore\CommandBus\Domain\Exception\CommandFailedException;

interface CommandBusInterface
{
    /**
     * Executes the given command and optionally returns a value
     *
     * @return mixed
     *
     * @throws CommandFailedException
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
    public function handle(object $command);
}
