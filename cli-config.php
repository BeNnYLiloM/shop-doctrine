<?php

require_once "main.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);