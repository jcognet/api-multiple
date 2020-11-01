<?php


namespace App\Command\Old;


use App\Service\OpenBreweryDb;
use App\Service\PunkApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PunkResearchCommand extends Command
{
    protected static $defaultName = 'brewery:get:punk';

    /**
     * @var PunkApi
     */
    private $punkApi;

    /**
     * OpenBreweryDbResearchCommand constructor.
     * @param string|null $name
     * @param PunkApi $punkApi
     */
    public function __construct(string $name = null, PunkApi $punkApi)
    {
        parent::__construct($name);

        $this->punkApi = $punkApi;
    }

    protected function configure()
    {
        $this->setDescription('Recherche une brasserie via PunkApi')
            ->setHelp('Recherche une brasserie en faisant appel à l\'API Punk. Merci à eux')
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

        $breweries = $this->punkApi->callApi($input->getArgument('keyword'));

        foreach ($breweries as $brewery) {
            $output->writeln($brewery);
        }

        $output->writeln('Bye ! ');
        return Command::SUCCESS;
    }
}
