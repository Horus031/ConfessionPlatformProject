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
        $this->clients->attach($conn);
        echo "New connection ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        global $pdo;
        $data = json_decode($msg, true);

        if (isset($data['type'])) {
            if ($data['type'] === 'comment') {
                $response = [
                    "type" => "comment",
                    "postId" => $data['postId'],
                    "userId" => $data['userId'],
                    "username" => $data['username'],
                    "avatar" => $data['avatar'],
                    "created_at" => date("Y-m-d H:i:s"),
                    "comment" => $data['comment']
                ];

                foreach ($this->clients as $client) {
                    $client->send(json_encode($response));
                }
            }

            if ($data['type'] === 'notification') {
                $stmt = $pdo->prepare("INSERT INTO notifications (user_id, sender_id, type , message, url) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $data['userId'],
                    $data['senderId'],
                    $data['notification_type'],
                    $data['message'],
                    $data['url']
                ]);

                $response = [
                    "type" => "notification",
                    "receiverId" => $data['user_id'],
                    "notification_type" => $data['notification_type'],
                    "message" => $data['message'],
                    "url" => $data['url'],
                    "created_at" => date("Y-m-d H:i:s")
                ];

                // Gửi thông báo đến tất cả client (hoặc lọc theo receiverId nếu cần)
                foreach ($this->clients as $client) {
                    $client->send(json_encode($response));
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
