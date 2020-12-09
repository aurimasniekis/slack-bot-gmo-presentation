<?php

declare(strict_types=1);

namespace App\Slack\Controller;

use App\Slack\Command\BaseSlackCommand;
use App\Slack\Model\SlackCommandRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Aurimas Niekis <aurimas@niekis.lt>
 *
 *
 * @Route("/slack/command", methods={"POST"}, name="slack_command_handler")
 */
class SlackCommandHandler
{
    /**
     * @var BaseSlackCommand[]
     */
    private array $commands;

    public function __construct(iterable $commands)
    {
        foreach ($commands as $command) {
            $this->add($command);
        }
    }

    public function add(BaseSlackCommand $command): void
    {
        $this->commands[$command->getCommandName()] = $command;
    }

    public function __invoke(Request  $request): Response
    {
        $commandRequest = SlackCommandRequest::fromRequest($request);

        if (false === isset($this->commands[$commandRequest->getCommand()])) {
            throw new NotFoundHttpException();
        }

        $commandHandler = $this->commands[$commandRequest->getCommand()];

        return new JsonResponse($commandHandler->handleCommand($commandRequest));
    }
}
