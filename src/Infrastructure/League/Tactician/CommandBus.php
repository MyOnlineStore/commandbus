<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Infrastructure\League\Tactician;

use League\Tactician\CommandBus as TacticianCommandBus;
use MyOnlineStore\CommandBus\Application\CommandBusInterface;

final class CommandBus implements CommandBusInterface
{
    private TacticianCommandBus $commandBus;

    public function __construct(TacticianCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @inheritdoc
     */
    public function handle(object $command)
    {
        return $this->commandBus->handle($command);
    }
}
