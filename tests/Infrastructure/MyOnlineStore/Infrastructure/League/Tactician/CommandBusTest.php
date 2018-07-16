<?php
declare(strict_types=1);

namespace MyOnlineStore\CommandBus\Tests\Infrastructure\League\Tactician;

use MyOnlineStore\CommandBus\Infrastructure\League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;
use League\Tactician\CommandBus as TacticianCommandBus;

final class CommandBusTest extends TestCase
{
    /**
     * @var TacticianCommandBus
     */
    private $tacticianCommandBus;

    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp()
    {
        $this->tacticianCommandBus = $this->createMock(TacticianCommandBus::class);

        $this->commandBus = new CommandBus($this->tacticianCommandBus);
    }

    public function testWillThrowOnTheBus()
    {
        $command = new \stdClass();

        $this->tacticianCommandBus->expects(self::once())
            ->method('handle')
            ->with($command);

        $this->commandBus->handle($command);
    }
}
