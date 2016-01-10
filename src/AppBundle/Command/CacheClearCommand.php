<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CacheClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:cache:clear')
            ->setDescription('Clears application cache.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> clears application cache.

<info>php %command.full_name%</info>
<info>php %command.full_name% --env=prod</info>

EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $this->getContainer()->getParameter('kernel.environment');
        $output->writeLn("Clearing app cache for environment <comment>{$env}</comment>...");

        $cache = $this->getContainer()->get('cache.default');
        $cache->flushAll();

        $output->writeLn("Cache was cleared.");
    }
}
