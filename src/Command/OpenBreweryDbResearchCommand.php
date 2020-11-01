<?php


namespace App\Command;


use App\Service\OpenBreweryDb;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OpenBreweryDbResearchCommand extends Command
{
    protected static $defaultName = 'brewery:get:open-brewery-db';

    /**
     * @var OpenBreweryDb
     */
    private $breweryDb;

    /**
     * OpenBreweryDbResearchCommand constructor.
     * @param string|null $name
     * @param OpenBreweryDb $breweryDb
     */
    public function __construct(string $name = null, OpenBreweryDb $breweryDb)
    {
        parent::__construct($name);

        $this->breweryDb = $breweryDb;
    }

    protected function configure()
    {
        $this->setDescription('Recherche une brasserie via openBreweryDB')
            ->setHelp('Recherche une brasserie en faisant appel à l\'API Open Brewery. Merci à eux')
            ->addArgument('keyword', InputArgument::REQUIRED, 'Mot clé à chercher');
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
        $output->writeln(sprintf('Lancement de la commande %s à %s le %s', self::$defaultName, $now->format('H:i:s'), $now->format('d/m/Y')));
        $output->writeln(sprintf('Mot clé à chercher : %s', $input->getArgument('keyword')));

        $breweries = $this->breweryDb->callApi($input->getArgument('keyword'));

        foreach ($breweries as $brewery) {
            $output->writeln($brewery);
        }

        $end = new \DateTime();
        $duration = $end - $now;

        $output->writeln('Bye ! ');
        $output->writeln(sprintf('Duration : %s s', $duration->format('%S')));
        return Command::SUCCESS;
    }
}
