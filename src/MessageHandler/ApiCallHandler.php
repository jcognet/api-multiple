<?php


namespace App\MessageHandler;


use App\Message\ApiCallNotification;
use App\Service\ApiCaller\BreweryResearchApi;
use App\Service\ResearchApiCaller;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ApiCallHandler implements MessageHandlerInterface
{
    /**
     * @var ResearchApiCaller
     */
    private $researchApiCaller;

    /**
     * ApiCallHandler constructor.
     *
     * @param ResearchApiCaller $researchApiCaller
     */
    public function __construct(ResearchApiCaller $researchApiCaller)
    {
        $this->researchApiCaller = $researchApiCaller;
    }

    /**
     * @param ApiCallNotification $apiCallNotification
     */
    public function __invoke(ApiCallNotification $apiCallNotification)
    {
        /** @var BreweryResearchApi $service */
        $service = $this->researchApiCaller->getClass($apiCallNotification->getType());

        return $service->getResult($apiCallNotification->getUrl());
    }
}
