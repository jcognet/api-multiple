<?php


namespace App\Service\ApiCaller;


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
     * BreweryResearchApi constructor.
     *
     * @param HttpClientInterface $client
     * @param int $maxRandomSleepTime
     */
    public function __construct(HttpClientInterface $client, int $maxRandomSleepTime)
    {
        $this->client = $client;
        $this->maxRandomSleepTime = $maxRandomSleepTime;
    }

    /**
     * @param string $keyword
     *
     * @return array|null
     */
    public function callApi(string $keyword): ?array
    {
        $response = $this->client->request('GET',
            $this->getUrl($keyword)
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
