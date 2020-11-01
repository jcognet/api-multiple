<?php


namespace App\Service;

use App\Entity\Brewery;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class PunkApi
 *
 * Source : https://punkapi.com
 *
 * @package App\Service
 */
class PunkApi implements BreweryResearchApiInterface
{
    /**
     * URL pour requête l'API
     */
    private const URL = 'https://api.punkapi.com/v2/beers';

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
            self::URL . '?beer_name=' . $keyword
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
                'Punk',
                $responseBrewery['name'],
            'England',
                $responseBrewery['tagline'],
                $responseBrewery['image_url']
            );
        }

        return $formattedData;
    }
}
