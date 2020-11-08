<?php

namespace App\Service\ApiCaller;

use App\Entity\Brewery;

/**
 * Class PunkApi.
 *
 * Source : https://punkapi.com
 */
class PunkApi extends BreweryResearchApi implements BreweryApiInterface
{
    /**
     * URL pour requête l'API.
     */
    private const URL = 'https://api.punkapi.com/v2/beers';

    /**
     * {@inheritdoc}
     */
    public function getUrl(string $keyword): string
    {
        return self::URL.'?beer_name='.$keyword;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatData(array $data): array
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
