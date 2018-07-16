<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Application;

use MyOnlineStore\CommandBus\Domain\Exception\CommandFailedException;

interface CommandBusInterface
{
    /**
     * Executes the given command and optionally returns a value
     *
     * @param object $command
     *
     * @return mixed
     *
     * @throws CommandFailedException
     */
    public function handle($command);
}
