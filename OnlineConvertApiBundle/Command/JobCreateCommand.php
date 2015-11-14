<?php

namespace Aacp\OnlineConvertApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JobCreateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('oc:job:create')
            ->setDescription('Create New Job')
            ->addArgument('category', InputArgument::REQUIRED)
            ->addArgument('target', InputArgument::REQUIRED)
            ->addArgument('input', InputArgument::REQUIRED);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $category = $input->getArgument('category');
        $target = $input->getArgument('target');
        $source = $input->getArgument('input');
        $jobCreator = $this->getContainer()->get('oc.all_conversions');

        $options = [ 'rewq' ];

        $jobCreated = $jobCreator->newConversion($source, $category, $target, $options);

//        $output->writeln(print_r($jobCreated));


        if ($jobCreator->lookStatus() == true) {
            $output->writeln($jobCreator->getStatus());
        }
    }
}
