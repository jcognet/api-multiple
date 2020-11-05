<?php


namespace App\Message;


class ApiCallNotification
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
     * ApiCallNotification constructor.
     *
     * @param string $url
     * @param string $type
     */
    public function __construct(string $url, string $type)
    {
        $this->url = $url;
        $this->type = $type;
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
}
