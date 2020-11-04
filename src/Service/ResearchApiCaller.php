<?php


namespace App\Service;


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
     * @param string $keyword
     *
     * @return array
     */
    public function callAllApi(string $keyword):array
    {
        $breweries = [];

        /** @var BreweryResearchApi $api **/
        foreach($this->listResearchApiHelper as $api){
            $breweries = array_merge($breweries, $api->callApi($keyword));
        }

        return $breweries;
    }
}
