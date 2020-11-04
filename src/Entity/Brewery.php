<?php


namespace App\Entity;


class Brewery
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $url;
    /**
     * @var string
     */
    private $originApi;

    /**
     * Brewery constructor.
     *
     * @param string $originApi
     * @param string $name
     * @param string $country
     * @param string|null $type
     * @param string|null $url
     */
    public function __construct(string $originApi, string $name, string $country, ?string $type, ?string $url)
    {
        $this->name = $name;
        $this->country = $country;
        $this->type = $type;
        $this->url = $url;
        $this->originApi = $originApi;
    }

    /**
     * @return string
     */
    public function getOriginApi(): string
    {
        return $this->originApi;
    }

    /**
     * @param string $originApi
     */
    public function setOriginApi(string $originApi): void
    {
        $this->originApi = $originApi;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function __toString()
    {
        return sprintf(
            '%s made in %s, type : %s, details : %s (origin : %s)',
            $this->getName(),
            $this->getCountry(),
            $this->getType(),
            $this->getUrl(),
            $this->getOriginApi()
        );
    }
}
