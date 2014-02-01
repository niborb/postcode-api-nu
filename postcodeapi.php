#!/usr/bin/php
<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 25-01-14
 */

require 'vendor/autoload.php';

use Niborb\PostcodeAPI\Command\PostcodeApiAddressCommand;
use Niborb\PostcodeAPI\Command\PostcodeApiWgs84Command;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new PostcodeApiAddressCommand());
$application->add(new PostcodeApiWgs84Command());
$application->run();