<?php

declare(strict_types=1);


namespace App\Command;


use App\Services\Checker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PlayCheckCommand
 * @package App\Command
 */
class PlayCheckCommand extends Command
{
    /** @var string  */
    protected static $defaultName = 'app:play-check';

    private Checker $checker;

    /**
     * PlayCheckCommand constructor.
     * @param Checker $checker
     */
    public function __construct(Checker $checker)
    {
        parent::__construct();

        $this->checker = $checker;
    }


    protected function configure()
    {
        $this
            ->setDescription('Check mpd resource play status')
            ->setHelp('This command allows you to check mpd resource play status.')
            ->addArgument('source', InputArgument::REQUIRED, 'Source name for email message body')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('source');
        $result = $this->checker->check($source);

        $output->writeln(sprintf('Check command was done with status %s', $result ? 'true' : 'false'));

        return 0;
    }


}