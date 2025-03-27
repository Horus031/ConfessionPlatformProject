<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class LikeCommentServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryParams);

        if (isset($queryParams['user_id'])) {
            $conn->userId = $queryParams['user_id']; // Store the user ID in the connection object
        }

        $this->clients->attach($conn);
        echo "New connection ({$conn->resourceId}) with user ID: {$conn->userId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        global $pdo;
        $data = json_decode($msg, true);

        if (isset($data['type'])) {
            if ($data['type'] === 'like') {
                $response = [
                    "type" => "like",
                    "postId" => $data['postId'],
                    "likesCount" => $data['likes'],
                ];

                foreach ($this->clients as $client) {
                    $client->send(json_encode($response));
                }
            }


            if ($data['type'] === 'comment') {
                $response = [
                    "type" => "comment",
                    "postId" => $data['postId'],
                    "userId" => $data['userId'],
                    "username" => $data['username'],
                    "avatar" => $data['avatar'],
                    "created_at" => $data['createdTime'],
                    "comment" => $data['comment'],
                    "commentCount" => $data['commentCount']
                ];

                foreach ($this->clients as $client) {
                    $client->send(json_encode($response));
                }
            }

            if ($data['type'] === 'notification') {
                $response = [
                    "type" => "notification",
                    "receiverId" => $data['user_id'],
                    "username" => $data['username'],
                    "avatar" => $data['avatar'],
                    "senderId" => $data['senderId'],
                    "notification_type" => $data['notification_type'],
                    "message" => $data['message'],
                    "content" => $data['content'],
                    "url" => $data['url'],
                    "created_at" => $data['createdTime']
                ];

                // Gửi thông báo đến tất cả client (hoặc lọc theo receiverId nếu cần)
                foreach ($this->clients as $client) {
                    if (isset($client->userId) && $client->userId == $data['user_id']) {
                        $client->send(json_encode($response));
                    }
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(new WsServer(new LikeCommentServer())),
    8080 // Cổng WebSocket
);

echo "WebSocket server running on ws://localhost:8080\n";
$server->run();
