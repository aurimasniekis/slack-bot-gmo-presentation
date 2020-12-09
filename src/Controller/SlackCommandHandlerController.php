<?php

namespace App\Controller;

use App\Slack\Command\BaseSlackCommand;
use App\Slack\Model\SlackCommandRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SlackCommandHandlerController extends AbstractController
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

    /**
     * @Route("/slack/command/handler", name="slack_command_handler")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $commandRequest = SlackCommandRequest::fromRequest($request);

        if (false === isset($this->commands[$commandRequest->getCommand()])) {
            throw new NotFoundHttpException();
        }

        $commandHandler = $this->commands[$commandRequest->getCommand()];

        return new JsonResponse($commandHandler->handleCommand($commandRequest));
    }
}
