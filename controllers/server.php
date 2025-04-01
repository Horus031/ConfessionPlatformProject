<?php
require 'vendor/autoload.php';
require __DIR__ . '/../includes/dbconnection.php';
require __DIR__ . '/../includes/dbfunctions.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class NotificationServer implements MessageComponentInterface
{
    protected $clients;
    protected $pdo;


    public function __construct()
    {
        $this->clients = new \SplObjectStorage;

        // Create a new PDO connection
        $this->pdo = new PDO("mysql:host=localhost; dbname=confessiondb; charset=utf8mb4", "root", "Horusnee@!0312");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryParams);

        if (isset($queryParams['user_id'])) {
            $conn->userId = $queryParams['user_id']; // Store the user ID in the connection object
        } else {
            echo "Connection {$conn->resourceId} does not have a user ID.\n";
        }

        $this->clients->attach($conn);
        echo "New connection ({$conn->resourceId}) with user ID: {$conn->userId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
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

                foreach ($this->clients as $client) {
                    if (isset($client->userId) && $client->userId == $data['user_id']) {
                        $client->send(json_encode($response));
                    }
                }
            }

            // New notification type for new posts to followers
            if ($data['type'] === 'new_post') {
                $this->notifyFollowers($data);
            }
        }
    }

    protected function notifyFollowers($data)
    {
        // Extract post creator details
        $database = new Database($this->pdo);
        $creatorId = $data['user_id'];
        $username = $data['username'];
        $avatar = $data['avatar'];
        $postId = $data['postId'];
        $postTitle = isset($data['postTitle']) ? $data['postTitle'] : '';
        $postContent = isset($data['postContent']) ? substr($data['postContent'], 0, 100) : '';
        $createdTime = $data['createdTime'];

        try {
            // Get all followers of the post creator
            $followers = $database->getAllFollowers($creatorId);

            if (empty($followers)) {
                echo "User {$creatorId} has no followers to notify.\n";
                return;
            }

            echo "Notifying " . count($followers) . " followers about new post from user {$creatorId}\n";

            // Prepare notification data
            $notification = [
                "type" => "new_post",
                "senderId" => $creatorId,
                "username" => $username,
                "avatar" => $avatar,
                "postId" => $postId,
                "notification_type" => $data['notification_type'],
                "message" => "has shared a new post",
                "title" => $postTitle,
                "content" => $postContent,
                "url" => $data['url'],
                "created_at" => $createdTime
            ];

            foreach ($followers as $followerId) {
                echo "Notifying follower {$followerId['user_id']} about new post from user {$creatorId}\n";
                // Save notification in database
                $database->sendNotifications($followerId['user_id'], $creatorId, 'new_post', $notification['message'], $notification['title'], $notification['url']);

                // Send real-time notification to online followers
                $notification['receiverId'] = $followerId['user_id'];

                foreach ($this->clients as $client) {
                    if (isset($client->userId) && $client->userId == $followerId['user_id']) {
                        $client->send(json_encode($notification));
                        echo "Sent notification to user {$followerId['user_id']}\n";
                    }
                }
            }
        } catch (\PDOException $e) {
            echo "Error notifying followers: " . $e->getMessage() . "\n";
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
    new HttpServer(new WsServer(new NotificationServer())),
    8080 // Cổng WebSocket
);

echo "WebSocket server running on ws://localhost:8080\n";
$server->run();
