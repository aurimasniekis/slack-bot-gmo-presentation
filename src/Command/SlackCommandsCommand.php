<?php

namespace App\Command;

use App\Slack\Command\BaseSlackCommand;
use Doctrine\ORM\Query\Expr\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SlackCommandsCommand extends Command
{
    protected static $defaultName = 'slack:commands';

    /** @var BaseSlackCommand[] */
    protected iterable $commands;

    public function __construct(iterable $commands)
    {
        parent::__construct();

        $this->commands = $commands;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $rows = [];

        foreach ($this->commands as $command) {
            $rows[] = [
                $command->getCommandName(),
                get_class($command)
            ];
        }

        $io->table(['Name', 'Class'], $rows);

        return Command::SUCCESS;
    }
}
