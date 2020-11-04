<?php


namespace App\Command;


use App\Service\ResearchApiCaller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BreweryResearchCommand extends Command
{
    protected static $defaultName = 'brewery:get:all';

    /**
     * @var ResearchApiCaller
     */
    private $researchApiCaller;

    /**
     * OpenBreweryDbResearchCommand constructor.
     *
     * @param string|null $name
     * @param ResearchApiCaller $researchApiCaller
     */
    public function __construct(string $name = null, ResearchApiCaller $researchApiCaller)
    {
        parent::__construct($name);

        $this->researchApiCaller = $researchApiCaller;
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
        $listRegisteredApi = $this->researchApiCaller->getListService();
        $output->writeln(sprintf('Number of API : %s', count($listRegisteredApi)));

        foreach (array_keys($listRegisteredApi) as $apiName) {
            $output->writeln(sprintf('API class : %s', $apiName));
        }

        $breweries = $this->researchApiCaller->callAllApi($input->getArgument('keyword'));

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
