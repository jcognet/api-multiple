<?php

namespace App\MessageHandler;

use App\Message\ApiAnswerNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiAnswerHandler implements MessageHandlerInterface
{
    /**
     * @var WebSocketHandler
     */
    private $webSocketHandler;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ApiAnswerHandler constructor.
     *
     * @param WebSocketHandler $webSocketHandler
     * @param SerializerInterface $serializer
     */
    public function __construct(WebSocketHandler $webSocketHandler, SerializerInterface $serializer)
    {
        $this->webSocketHandler = $webSocketHandler;
        $this->serializer = $serializer;
    }

    /**
     * @param ApiAnswerNotification $apiAnswerNotification
     */
    public function __invoke(ApiAnswerNotification $apiAnswerNotification)
    {
        $conn = $this->webSocketHandler->getConnection($apiAnswerNotification->getUniqueId());

        if ($conn) {
            $json = $this->serializer->serialize(
                $apiAnswerNotification->getBreweries(),
                'json'
            );

            $conn->send($json);
        }
    }
}
