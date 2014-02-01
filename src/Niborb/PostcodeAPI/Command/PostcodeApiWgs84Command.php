<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 02-02-14
 */

namespace Niborb\PostcodeAPI\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PostcodeApiWgs84Command extends PostcodeApiCommand
{

    /**
     *
     */
    protected function configure()
    {
        parent::configure('wgs84');
        $this->setDescription('get postcode information based on geo-location')
            ->addArgument('latitude', InputArgument::REQUIRED)
            ->addArgument('longitude', InputArgument::REQUIRED);

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $latitude = $input->getArgument('latitude');
        $longitude = $input->getArgument('longitude');

        $client = $this->getPostCodeApi();

        try {

            $address = $client->getAddressByLatitudeAndLongitude($latitude, $longitude);

            $output->writeln("<info>address found:\n" . $address . "</info>");
        } catch (\Exception $e) {
            $output->writeln('<error>Error '. $e->getMessage() . '</error>');
            $output->writeln('<error>' .$e->getTraceAsString() . '</error>');
            return 1;
        }


        return 0;
    }
}