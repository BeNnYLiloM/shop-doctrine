<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ConsoleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('demo:greet')
            ->setDescription('Greet someone')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if($name) {
            $text = 'Hello '.$name;
        } else {
            $text = 'Hello';
        }

        if($input->getOption('yell')){
            $text = strtoupper($text);
        }

        $style = new OutputFormatterStyle('black', 'white', array('blink'));
        $output->getFormatter()->setStyle('fire', $style);
        $output->writeln('<fire>'.$text.'</fire>');
    }
}