<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 25-01-14
 */

namespace Niborb\PostcodeAPI\Command;



use Niborb\PostcodeAPI\PostcodeAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PostcodeApiAddressCommand
 * @package Niborb\PostcodeAPI\Command
 */
class PostcodeApiAddressCommand extends PostcodeApiCommand
{

    /**
     *
     */
    protected function configure()
    {
        parent::configure('address');
        $this->setDescription('get postcode information')
             ->addArgument('postcode', InputArgument::REQUIRED, 'The postcode')
             ->addArgument('houseNumber', InputArgument::OPTIONAL, 'The house number');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $postcode = $input->getArgument('postcode');
        $houseNumber = $input->getArgument('houseNumber');

        $client = $this->getPostCodeApi();

        try {
            if ($houseNumber != '') {
                $address = $client->getAddressByPostalcodeAndHouseNumber($postcode, $houseNumber);
            } else {
                $address = $client->getAddressByPostalcode($postcode);
            }

            $output->writeln("<info>address found:\n" . $address . "</info>");
        } catch (\Exception $e) {
            $output->writeln('<error>Error '. $e->getMessage() . '</error>');
            $output->writeln('<error>' .$e->getTraceAsString() . '</error>');
            return 1;
        }


        return 0;
    }


}