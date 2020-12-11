<?php

declare(strict_types=1);

namespace App\Slack\Command;

use App\Message\DoSomethingMessage;
use App\Slack\Model\SlackCommandRequest;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
class FooCommand extends BaseSlackCommand
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function handleCommand(SlackCommandRequest $request): array
    {
        $this->bus->dispatch(new DoSomethingMessage($request->getText()));

        return ['text' => 'Foo bar'];
    }

    public function getCommandName(): string
    {
        return '/foo';
    }

}
