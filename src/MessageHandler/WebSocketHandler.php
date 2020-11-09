<?php

namespace App\MessageHandler;

use App\Service\ApiCaller\BreweryResearchApi;
use App\Service\ResearchApiCaller;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\Serializer\SerializerInterface;

class WebSocketHandler implements MessageComponentInterface
{
    /**
     * @var ResearchApiCaller
     */
    private $researchApiCaller;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $connections;

    /**
     * WebSocketlHandler constructor.
     *
     * @param ResearchApiCaller $researchApiCaller
     * @param SerializerInterface $serializer
     */
    public function __construct(ResearchApiCaller $researchApiCaller, SerializerInterface $serializer)
    {
        $this->researchApiCaller = $researchApiCaller;
        $this->serializer = $serializer;
        $this->connections = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections[uniqid()] = $conn;
    }

    public function onClose(ConnectionInterface $conn)
    {
        if (($key = array_search($conn, $this->connections)) !== false) {
            unset($this->connections[$key]);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $connectionId = array_search($from, $this->connections);

        if (!$connectionId) {
            throw new \LogicException('Unknown connection');
        }

        $msgDecoded = json_decode($msg);
        $keyword = $msgDecoded->keyword;

        /** @var BreweryResearchApi $api * */
        foreach ($this->researchApiCaller->getListService() as $api) {
            $api->callApiWithMessage($keyword, $connectionId);
        }
    }

    /**
     * @param string $connectionId
     *
     * @return ConnectionInterface|null
     */
    public function getConnection(string $connectionId)
    {
        if (isset($this->connections[$connectionId])) {
            return $this->connections[$connectionId];
        }

        return null;
    }
}
