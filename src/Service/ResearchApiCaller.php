<?php

namespace App\Service;

use App\Service\ApiCaller\BreweryResearchApi;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ResearchApiCaller
{
    /**
     * @var array
     */
    private $listResearchApiHelper;

    /**
     * ResearchApiHelper constructor.
     *
     * @param iterable $listResearchApiHelper
     */
    public function __construct(iterable $listResearchApiHelper)
    {
        $this->listResearchApiHelper = iterator_to_array($listResearchApiHelper);
    }

    /**
     * @return array
     */
    public function getListService(): array
    {
        return $this->listResearchApiHelper;
    }

    /**
     * @param string $class
     *
     * @return BreweryResearchApi
     */
    public function getClass(string $class): BreweryResearchApi
    {
        foreach ($this->getListService() as $service) {
            if ($class === get_class($service)) {
                return $service;
            }
        }

        throw new \LogicException(sprintf('Unknown class : %s', $class));
    }

    /**
     * @param string $keyword
     *
     * @return array
     */
    public function callAllApi(string $keyword): array
    {
        $breweries = [];

        /** @var BreweryResearchApi $api * */
        foreach ($this->listResearchApiHelper as $api) {
            $breweries = array_merge($breweries, $api->callApi($keyword));
        }

        return $breweries;
    }

    /**
     * @param string $keyword
     *
     * @return array
     */
    public function callApiAllWithMessage(string $keyword): array
    {
        $breweries = [];

        /** @var BreweryResearchApi $api * */
        foreach ($this->listResearchApiHelper as $api) {
            $breweries = array_merge(
                $breweries,
                $api->callApiWithMessage($keyword)->last(HandledStamp::class)->getResult()
            );
        }

        return $breweries;
    }
}
