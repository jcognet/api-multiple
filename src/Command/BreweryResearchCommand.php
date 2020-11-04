<?php


namespace App\Command;


use App\Service\OpenBeerDatabase;
use App\Service\OpenBreweryDb;
use App\Service\PunkApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BreweryResearchCommand extends Command
{
    protected static $defaultName = 'brewery:get:all';

    /**
     * @var PunkApi
     */
    private $punkApi;

    /**
     * @var OpenBreweryDb
     */
    private $breweryDb;

    /**
     * @var OpenBeerDatabase
     */
    private $openBeerDatabase;

    /**
     * OpenBreweryDbResearchCommand constructor.
     *
     * @param string|null $name
     * @param PunkApi $punkApi
     * @param OpenBreweryDb $breweryDb
     * @param OpenBeerDatabase $openBeerDatabase
     */
    public function __construct(string $name = null, PunkApi $punkApi, OpenBreweryDb $breweryDb, OpenBeerDatabase $openBeerDatabase)
    {
        parent::__construct($name);

        $this->punkApi = $punkApi;
        $this->breweryDb = $breweryDb;
        $this->openBeerDatabase = $openBeerDatabase;
    }

    protected function configure()
    {
        $this->setDescription('Seek breweries in all APIs with a given keywords')
            ->addArgument('keyword', InputArgument::REQUIRED, 'keyword to seek');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $output->writeln(sprintf('Start of the command %s at %s %s', self::$defaultName, $now->format('H:i:s'), $now->format('d/m/Y')));
        $output->writeln(sprintf('Keyword to find : %s', $input->getArgument('keyword')));

        $punkBreweries = $this->punkApi->callApi($input->getArgument('keyword'));
        $openBreweryDbBreweries = $this->breweryDb->callApi($input->getArgument('keyword'));
        $openBeerBreweries = $this->openBeerDatabase->callApi($input->getArgument('keyword'));
        $breweries = array_merge($punkBreweries, $openBreweryDbBreweries, $openBeerBreweries);

        foreach ($breweries as $brewery) {
            $output->writeln($brewery);
        }

        $end = new \DateTime();
        $duration = $end->diff($now);

        $output->writeln('Bye ! ');
        $output->writeln(sprintf('Duration : %s s', $duration->format('%S')));

        return Command::SUCCESS;
    }
}
