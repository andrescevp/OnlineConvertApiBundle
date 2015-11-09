<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 05/11/2015
 * Time: 23:43
 */

namespace Aacp\OnlineConvertApiBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfoGenericCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('oc:info')
            ->setDescription(
                'Get the hole schema from Online Convert API. http://api2.online-convert.com/schema'
            )
            ->addArgument(
                'kind_information',
                InputArgument::REQUIRED,
                'Kind of information that you need'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kindInformation = $input->getArgument('kind_information');

        $information = $this->getContainer()->get('oc.information');

        if ($kindInformation === 'schema') {
            $output->writeln($information->getSchema());
        }

        if ($kindInformation === 'statuses') {
            $output->writeln($information->getStatuses());
        }
    }
}