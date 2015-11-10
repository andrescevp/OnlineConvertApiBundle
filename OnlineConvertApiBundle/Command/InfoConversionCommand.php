<?php

namespace Aacp\OnlineConvertApiBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfoConversionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('oc:info:conversion')
            ->setDescription(
                'Get the hole schema from Online Convert API. http://api2.online-convert.com/schema'
            )
            ->addArgument(
                'category',
                InputArgument::REQUIRED,
                'Category of the conversion'
            )
            ->addArgument(
                'target',
                InputArgument::OPTIONAL,
                'Target of the conversion'
            )
            ->addArgument(
                'page',
                InputArgument::OPTIONAL,
                '',
                1
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $category = $input->getArgument('category');
        $target = $input->getArgument('target');
        $page = $input->getArgument('page');

        $information = $this->getContainer()->get('oc.information');
        $output->writeln($information->getConversionInfo($category, $target, $page));
    }
}