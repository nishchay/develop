<?php

require_once dirname(__DIR__) . '/bootstrap/init.php';

use Nishchay\Processor\Application;
use Nishchay\Processor\Loader\Loader;
use Nishchay\Processor\SetUp\Configure;

/**
 * -------------------------------------------------
 * CONFIGURE ENVIRONMENT
 * -------------------------------------------------
 * 
 * Nishchay requires some setups to run the  application.
 * Configure class do work for us to setting up the system.
 */
new Configure();

/**
 * -------------------------------------------------
 * EXECUTE Nishchay
 * -------------------------------------------------
 * 
 * Now we have environment.
 * Launching application to execute your Nishchay(AIM).
 */
(new Application(new Loader))->run(Application::RUNNING_CONSOLE_TEST);