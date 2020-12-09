<?php

declare(strict_types=1);

namespace App\Slack\Command;

use App\Slack\Model\SlackCommandRequest;

/**
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
abstract class BaseSlackCommand
{
    abstract public function handleCommand(SlackCommandRequest $request): array;

    abstract public function getCommandName(): string;
}
