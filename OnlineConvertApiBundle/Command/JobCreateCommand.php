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
        $jobCreator = $this->getContainer()->get('oc.job.all_conversions');
        $jobCreator->category = $category;
        $jobCreator->target = $target;
        $jobCreated = $jobCreator->newJob($source);
        $jobCreated = get_object_vars($jobCreated);
        $outputJob = $jobCreator->jobCreator->output->getJobOutput($jobCreated['id']);
        $output->writeln(print_r($outputJob));
    }
}
