<?php

namespace ConsoleCommand;

use Symfony\Component\Console\Command\Command;

class CommandWithEntityManager extends Command
{
    protected $em;

    public function __construct($em){
        parent::__construct();

        $this->em = $em;
    }
}