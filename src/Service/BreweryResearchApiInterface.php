<?php


namespace App\Service;


interface BreweryResearchApiInterface
{
    public function callApi(string $keyword): ?array;
}
