<?php

namespace App\MessageHandler;

use App\Message\DoSomethingMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DoSomethingMessageHandler implements MessageHandlerInterface
{
    public function __invoke(DoSomethingMessage $message)
    {
        file_put_contents('/tmp/output_message.txt', $message->getName());
    }
}
