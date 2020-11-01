<?php


namespace App\Service;


use App\Entity\Brewery;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class OpenBreweryDb
 *
 * Source : https://www.openbrewerydb.org
 *
 * @package App\Service
 */
class OpenBreweryDb implements BreweryResearchApiInterface
{
    /**
     * URL pour requête l'API
     */
    private const URL = 'https://api.openbrewerydb.org/breweries/search';

    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function callApi(string $keyword): array
    {
        $response = $this->client->request('GET',
            self::URL . '?query=' . $keyword
        );
        $content = $response->toArray();

        return $this->formatData($content);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function formatData(array $data): array
    {
        $formattedData = [];

        foreach ($data as $responseBrewery) {
            $formattedData[] = new Brewery(
                'OpenBreweryDb',
                $responseBrewery['name'],
                $responseBrewery['country'],
                $responseBrewery['brewery_type'],
                $responseBrewery['website_url']
            );
        }

        return $formattedData;
    }
}
