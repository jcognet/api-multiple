<?php

namespace App\Service\ApiCaller;

use App\Message\ApiCallNotification;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class BreweryResearchApi
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var int
     */
    private $maxRandomSleepTime;

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * BreweryResearchApi constructor.
     *
     * @param HttpClientInterface $client
     * @param int $maxRandomSleepTime
     * @param MessageBusInterface $bus
     */
    public function __construct(HttpClientInterface $client, int $maxRandomSleepTime, MessageBusInterface $bus)
    {
        $this->client = $client;
        $this->maxRandomSleepTime = $maxRandomSleepTime;
        $this->bus = $bus;
    }

    /**
     * @param string $keyword
     *
     * @return array|null
     */
    public function callApi(string $keyword): ?array
    {
        return $this->getResult($this->getUrl($keyword));
    }

    /**
     * @param string $url
     *
     * @return array|null
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getResult(string $url): ?array
    {
        $response = $this->client->request('GET',
            $url
        );
        $content = $response->toArray();

        if ($this->maxRandomSleepTime > 0) {
            sleep(rand(0, $this->maxRandomSleepTime));
        }

        return $this->formatData($content);
    }

    /**
     * @param string $keyword
     *
     * @return Envelope
     */
    public function callApiWithMessage(string $keyword): Envelope
    {
        return $this->bus->dispatch(new ApiCallNotification($this->getUrl($keyword), get_class($this)));
    }

    /**
     * @param string $keyword
     *
     * @return string
     */
    abstract protected function getUrl(string $keyword): string;

    /**
     * @param array $data
     *
     * @return array|null
     */
    abstract protected function formatData(array $data): ?array;
}
