<?php


namespace App\Service;


use App\Entity\Brewery;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class OpenBreweryDb
 *
 * Source : https://data.opendatasoft.com/explore/dataset/open-beer-database%40public-us/table/
 *
 * @package App\Service
 */
class OpenBeerDatabase implements BreweryResearchApiInterface
{
    /**
     * URL pour requête l'API
     */
    private const URL = 'https://data.opendatasoft.com/api/records/1.0/search/?dataset=open-beer-database%40public-us&facet=style_name&facet=cat_name&facet=name_breweries&facet=country';

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
            self::URL . '&q=' . $keyword
        );
        $content = $response->toArray();

        return $this->formatData($content['records']);
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
                'Open Beer Database',
                $responseBrewery['fields']['name'],
                $responseBrewery['fields']['country'],
                $responseBrewery['fields']['cat_name'] ?? null,
                $responseBrewery['fields']['website'] ?? null
            );
        }

        return $formattedData;
    }
}
