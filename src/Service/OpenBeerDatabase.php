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
class OpenBeerDatabase extends BreweryResearchApi
{
    /**
     * URL pour requête l'API
     */
    private const URL = 'https://data.opendatasoft.com/api/records/1.0/search/?dataset=open-beer-database%40public-us&facet=style_name&facet=cat_name&facet=name_breweries&facet=country';

    /**
     * @inheritDoc
     */
    protected function getUrl(string $keyword): string
    {
        return self::URL . '&q=' . $keyword;
    }

    /**
     * @inheritDoc
     */
    protected  function formatData(array $data): array
    {
        $formattedData = [];

        foreach ($data['records'] as $responseBrewery) {
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
