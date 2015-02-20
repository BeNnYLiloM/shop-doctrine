<?php

require_once "bin/console";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);