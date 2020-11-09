<?php

namespace App\Command;

use App\MessageHandler\WebSocketHandler;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebsocketServerCommand extends Command
{
    protected static $defaultName = 'brewery:websocket-server:start';

    /**
     * @var WebSocketHandler
     */
    private $webSocketlHandler;

    /**
     * @var string
     */
    private $websocketServerPort;

    protected function configure()
    {
        $this->setDescription('Start websocket server');
    }

    /**
     * WebsocketServerCommand constructor.
     *
     * @param string|null $name
     * @param string $websocketServerPort
     * @param WebSocketHandler $webSocketlHandler
     */
    public function __construct(string $name = null, string $websocketServerPort, WebSocketHandler $webSocketlHandler)
    {
        parent::__construct($name);

        $this->webSocketlHandler = $webSocketlHandler;
        $this->websocketServerPort = $websocketServerPort;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $output->writeln(sprintf('Start of the command %s at %s %s', self::$defaultName, $now->format('H:i:s'), $now->format('d/m/Y')));
        $output->writeln(sprintf('Server listens on %s', $this->websocketServerPort));
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    $this->webSocketlHandler
                )
            ),
            $this->websocketServerPort
        );
        $server->run();

        return Command::SUCCESS;
    }
}
