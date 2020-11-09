<?php

namespace App\Message;

class ApiAnswerNotification
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $breweries;

    /**
     * @var string
     */
    private $uniqueId;

    /**
     * ApiAnswerNotification constructor.
     *
     * @param string $url
     * @param string $type
     * @param array $breweries
     * @param string $uniqueId
     */
    public function __construct(string $url, string $type, array $breweries, string $uniqueId)
    {
        $this->url = $url;
        $this->type = $type;
        $this->breweries = $breweries;
        $this->uniqueId = $uniqueId;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getBreweries(): array
    {
        return $this->breweries;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}
