<?php

namespace App\Service\ApiCaller;

use App\Entity\Brewery;

/**
 * Class OpenBreweryDb.
 *
 * Source : https://www.openbrewerydb.org
 */
class OpenBreweryDb extends BreweryResearchApi implements BreweryApiInterface
{
    /**
     * URL pour requête l'API.
     */
    private const URL = 'https://api.openbrewerydb.org/breweries/search';

    /**
     * {@inheritdoc}
     */
    protected function getUrl(string $keyword): string
    {
        return self::URL.'?query='.$keyword;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatData(array $data): array
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
