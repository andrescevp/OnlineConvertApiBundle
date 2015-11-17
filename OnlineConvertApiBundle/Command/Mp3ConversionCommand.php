<?php

namespace Aacp\OnlineConvertApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Mp3ConversionCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('oc:job:conversion:mp3')
            ->setDescription('Create Mp3 Conversion')
            ->addArgument('input', InputArgument::REQUIRED);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $source = $input->getArgument('input');
        $jobCreator = $this->getContainer()->get('oc.job.mp3');

        $options = [ 'normalize' => true ];

        $jobCreated = $jobCreator->newJob($source, $options);

        $output->writeln(print_r($jobCreated));


//        if ($jobCreator->lookStatus() == true) {
//            $output->writeln($jobCreator->getStatus());
//        }
    }
}
