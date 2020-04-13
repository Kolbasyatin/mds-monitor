<?php

declare(strict_types=1);


namespace App\Command;


use App\Services\PlayChecker;
use Symfony\Component\Console\Command\Command;
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
    /**
     * @var PlayChecker
     */
    private PlayChecker $playChecker;

    /**
     * PlayCheckCommand constructor.
     * @param PlayChecker $playChecker
     */
    public function __construct(PlayChecker $playChecker)
    {
        $this->playChecker = $playChecker;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Check mpd resource play status')
            ->setHelp('This command allows you to check mpd resource play status.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }


}