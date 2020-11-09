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
     * @var string
     */
    private $uniqueId;

    /**
     * ApiCallNotification constructor.
     *
     * @param string $url
     * @param string $type
     * @param string|null $uniqueId
     */
    public function __construct(string $url, string $type, ?string $uniqueId)
    {
        $this->url = $url;
        $this->type = $type;
        $this->uniqueId = $uniqueId;
        if (!$uniqueId) {
            $this->uniqueId = uniqid();
        }
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
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}
