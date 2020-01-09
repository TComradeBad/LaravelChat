<?php


namespace App\Classes;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Class Chat
 * @package App\Classes
 */
class Chat implements MessageComponentInterface
{
    /** @var \SplObjectStorage */
    protected $clients;

    /**
     * Chat constructor.
     */
    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        /** @var ConnectionInterface $client */
        foreach ($this->clients as $client) {
            if ($client != $from) {
              $client->send($msg);
            }
        }

    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        foreach ($this->clients as $client){
            $client->send("One person out");
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Oh fuck, i can't believe you've done this" . PHP_EOL . $e->getMessage();
        $conn->close();
    }
}