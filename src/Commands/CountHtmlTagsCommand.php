<?php

declare(strict_types=1);

namespace HtmlParser\Commands;

use HtmlParser\Services\HtmlClient\HtmlClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CountHtmlTagsCommand extends Command
{
    public function __construct(
        private readonly HtmlClientInterface $htmlClient,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected static $defaultName = 'count-tags';

    protected static $defaultDescription = 'Counting html tags from given source';

    protected function configure()
    {
        $this->addArgument('url', InputArgument::REQUIRED, 'Site url for getting html content');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Requesting url ' . $input->getArgument('url') . '</info>');

        $document = $this->htmlClient->request('GET', $input->getArgument('url'));

        $output->writeln('<info>Total tags count: ' . $document->countTags() . '</info>');
        
        return 0;
    }
}