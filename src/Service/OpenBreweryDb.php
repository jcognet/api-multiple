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
class OpenBreweryDb extends BreweryResearchApi
{
    /**
     * URL pour requête l'API
     */
    private const URL = 'https://api.openbrewerydb.org/breweries/search';

    /**
     * @inheritDoc
     */
    protected function getUrl(string $keyword): string
    {
        return self::URL . '?query=' . $keyword;
    }

    /**
     * @inheritDoc
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
