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
     * BreweryResearchApi constructor.
     *
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
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
