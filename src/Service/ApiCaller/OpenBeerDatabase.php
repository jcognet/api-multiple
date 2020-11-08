<?php

namespace App\Service\ApiCaller;

use App\Entity\Brewery;

/**
 * Class OpenBeerDatabase.
 *
 * Source : https://data.opendatasoft.com/explore/dataset/open-beer-database%40public-us/table/
 */
class OpenBeerDatabase extends BreweryResearchApi implements BreweryApiInterface
{
    /**
     * URL pour requête l'API.
     */
    private const URL = 'https://data.opendatasoft.com/api/records/1.0/search/?dataset=open-beer-database%40public-us&facet=style_name&facet=cat_name&facet=name_breweries&facet=country';

    /**
     * {@inheritdoc}
     */
    protected function getUrl(string $keyword): string
    {
        return self::URL.'&q='.$keyword;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatData(array $data): array
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
