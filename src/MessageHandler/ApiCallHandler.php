<?php

namespace App\MessageHandler;

use App\Message\ApiAnswerNotification;
use App\Message\ApiCallNotification;
use App\Service\ApiCaller\BreweryResearchApi;
use App\Service\ResearchApiCaller;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ApiCallHandler implements MessageHandlerInterface
{
    /**
     * @var ResearchApiCaller
     */
    private $researchApiCaller;

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * ApiCallHandler constructor.
     *
     * @param ResearchApiCaller $researchApiCaller
     * @param MessageBusInterface $bus
     */
    public function __construct(ResearchApiCaller $researchApiCaller, MessageBusInterface $bus)
    {
        $this->researchApiCaller = $researchApiCaller;
        $this->bus = $bus;
    }

    /**
     * @param ApiCallNotification $apiCallNotification
     *
     * @return array|null
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function __invoke(ApiCallNotification $apiCallNotification)
    {
        /** @var BreweryResearchApi $service */
        $service = $this->researchApiCaller->getClass($apiCallNotification->getType());
        $result = $service->getResult($apiCallNotification->getUrl());
        $this->bus->dispatch(new ApiAnswerNotification(
            $apiCallNotification->getUrl(),
            $apiCallNotification->getType(),
            $result,
            $apiCallNotification->getUniqueId()
        ));

        return $result;
    }
}
