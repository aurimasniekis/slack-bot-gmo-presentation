<?php

namespace App\Slack\Command;

use App\Slack\Model\SlackCommandRequest;

class HelloWorldCommand extends BaseSlackCommand
{
    public function handleCommand(SlackCommandRequest $request): array
    {
        return [
            'response_type' => 'ephemeral',
            'text' => 'Hi there ' . $request->getUsername() . '! 👋'
        ];
    }

    public function getCommandName(): string
    {
        return '/hello';
    }
}