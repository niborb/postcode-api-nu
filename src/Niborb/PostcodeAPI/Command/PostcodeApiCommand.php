<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 02-02-14
 */

namespace Niborb\PostcodeAPI\Command;


use Niborb\PostcodeAPI\PostcodeAPI;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PostcodeApiCommand
 * @package Niborb\PostcodeAPI\Command
 */
abstract class PostcodeApiCommand extends BaseCommand
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param $name
     */
    protected function configure($name)
    {
        $this->setName('postcodeapi:'. $name);
        $this->addOption('apiKey', null, InputOption::VALUE_REQUIRED, ' The api key provided by postcodeapi.nu');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->apiKey = $input->getOption('apiKey');
    }


    /**
     * @return PostcodeAPI
     * @throws \RuntimeException
     */
    public function getPostCodeApi()
    {
        if (null === $this->apiKey) {
            throw new \RuntimeException('Api Key is not set');
        }

        return new PostcodeAPI($this->apiKey);
    }
}