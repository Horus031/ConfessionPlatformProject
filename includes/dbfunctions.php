<?php
if (!isset($_SESSION)) {
    session_start();
}
class Database
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function validateLogin($data)
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    public function validateRegistration($data, $user, $count)
    {
        $errors = [];

        if (isset($user['user_id'])) {
            $errors['userExist'] = 'User is already exists, please try another name';
        } elseif (strlen($data['username']) < 6) {
            $errors['userLength'] = 'Username must be at least 6 characters long';
        }

        if (isset($count['user_id'])) {
            $errors['emailExist'] = 'Email is already exists, please try another email';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['emailInvalid'] = 'Invalid email format';
        }

        if (strlen($data['password']) < 6) {
            $errors['passwordLength'] = 'Password must be at least 6 characters long';
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Passwords do not match, please try again';
        }

        return $errors;
    }

    public function updateDarkModePreference($userId, $darkMode)
    {
        $sql = "UPDATE users SET dark_mode = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$darkMode, $userId]);
    }

    public function getDarkModePreference($userId)
    {
        $sql = "SELECT dark_mode FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }


    public function fetchExistingImageURL($post_id)
    {
        $sql = "SELECT imageURL FROM posts WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        $existingPost = $stmt->fetch(PDO::FETCH_ASSOC);
        return $existingPost['imageURL'];
    }

    public function insertPost($user_id, $title, $content, $module_id, $imageURL)
    {
        $sql = 'INSERT INTO posts (user_id, post_title, post_content, module_id, imageURL) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $title, $content, $module_id, $imageURL]);
        return $this->pdo->lastInsertId();
    }

    public function fetchTagIds($tagArray)
    {
        if (!empty($tagArray)) {
            $placeholders = implode(',', array_fill(0, count($tagArray), '?'));
            $sql = "SELECT tag_id FROM tags WHERE tag_name IN ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($tagArray);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        return [];
    }

    public function insertPostTags($post_id, $tagIds)
    {
        $sql = "INSERT INTO posttags (post_id, tag_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($tagIds as $tag_id) {
            $stmt->execute([$post_id, $tag_id]);
        }
    }

    public function updatePost($post_id, $title, $content, $module_id, $imageURL)
    {
        $sql = "UPDATE posts SET
                post_title = ?,
                post_content = ?,
                module_id = ?,
                imageURL = ?
                WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$title, $content, $module_id, $imageURL, $post_id]);
    }

    public function deleteExistingTags($post_id)
    {
        $sql = "DELETE FROM posttags WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
    }

    public function deletePost($post_id)
    {
        $sql = "DELETE FROM posts WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
    }

    public function insertNewTags($post_id, $tagArray)
    {
        if (!empty($tagArray)) {
            $placeholders = implode(',', array_fill(0, count($tagArray), '?'));
            $sql = "SELECT tag_id FROM tags WHERE tag_name IN ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($tagArray);
            $tagIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $sql = "INSERT INTO posttags (post_id, tag_id) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            foreach ($tagIds as $tag_id) {
                $stmt->execute([$post_id, $tag_id]);
            }
        }
    }

    public function fetchExistingAvatarURL($user_id)
    {
        $sql = "SELECT avatar FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        return $existingUser['avatar'];
    }

    public function updateUser($user_id, $first_name, $last_name, $tag_name, $email, $avatarURL, $bio)
    {
        $sql = "UPDATE users SET
                first_name = ?,
                last_name = ?,
                tag_name = ?,
                email = ?,
                avatar = ?,
                bio = ?
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$first_name, $last_name, $tag_name, $email, $avatarURL, $bio, $user_id]);
    }

    public function updateUserSocialLinks($user_id, $social_links)
    {
        foreach ($social_links as $platform => $url) {
            if (!empty($url)) {
                $sql = "SELECT id FROM user_social_links WHERE user_id = ? AND platform = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$user_id, $platform]);
                $existing = $stmt->fetch();

                if ($existing) {
                    $sql = "UPDATE user_social_links SET url = ? WHERE user_id = ? AND platform = ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([$url, $user_id, $platform]);
                } else {
                    $sql = "INSERT INTO user_social_links (user_id, platform, url) VALUES (?, ?, ?)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([$user_id, $platform, $url]);
                }
            }
        }
    }

    public function fetchAllComments($post_id)
    {
        $sql = 'SELECT comments.comment_id, comments.user_id, comments.post_id, comments.content, comments.created_at, CONCAT(first_name, " ", last_name) AS fullname, users.username, users.avatar
                FROM ((comments
                INNER JOIN posts ON comments.post_id = posts.post_id)
                INNER JOIN users ON comments.user_id = users.user_id)
                WHERE posts.post_id = ?
                ORDER BY comments.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function postComment($user_id, $post_id, $content)
    {
        $sql = "INSERT INTO comments (user_id, post_id, content)
                VALUES (?, ?, ?)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $post_id, $content]);

        return $this->pdo->lastInsertId();
    }

    public function fetchNewComment($comment_id)
    {
        $sql = 'SELECT users.user_id, users.username, users.avatar, comments.comment_id, comments.content, comments.created_at 
        FROM comments 
        JOIN users ON comments.user_id = users.user_id 
        WHERE comments.comment_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$comment_id]);
        $new_comment = $stmt->fetch(PDO::FETCH_ASSOC);

        return $new_comment;
    }

    public function fetchPostDetails($post_id)
    {
        $sql = 'SELECT posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.created_at, posts.imageURL, users.avatar, users.username, COUNT(DISTINCT likes.like_id) as likes, COUNT(DISTINCT comments.comment_id) as comments, modules.module_id, modules.module_name, modules.bg_class, modules.text_class
                FROM ((((posts 
                INNER JOIN users ON posts.user_id = users.user_id)
                INNER JOIN modules ON posts.module_id = modules.module_id)
                LEFT JOIN likes ON posts.post_id = likes.post_id)
                LEFT JOIN comments ON posts.post_id = comments.post_id)
                WHERE posts.post_id = ?
                GROUP BY posts.post_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchPostTagsWithId($post_id)
    {
        $sql = 'SELECT tags.tag_id, tags.tag_name, tags.tag_description, tags.tag_type
                FROM tags
                JOIN posttags ON tags.tag_id = posttags.tag_id
                WHERE posttags.post_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllPostTags()
    {
        $sql = "SELECT posts.post_id, posts.post_title, tags.tag_id, tags.tag_name, tags.tag_description, tags.tag_type
                FROM posts
                JOIN posttags ON posts.post_id = posttags.post_id
                JOIN tags ON tags.tag_id = posttags.tag_id
                ORDER BY tag_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllPosts()
    {
        $sql = 'SELECT posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.view_count, posts.created_at, posts.imageURL, CONCAT(users.first_name, " ", users.last_name) AS fullname, users.avatar, users.username, users.tag_name, users.created_at AS userJoinedTime, modules.module_id, modules.module_name, modules.bg_class, modules.text_class 
                FROM ((((posts  
                INNER JOIN users ON posts.user_id = users.user_id)
                INNER JOIN modules ON posts.module_id = modules.module_id)
                LEFT JOIN likes ON posts.post_id = likes.post_id)
                LEFT JOIN comments ON posts.post_id = comments.post_id)
                GROUP BY post_id 
                ORDER BY posts.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchUserInfo($tag_name)
    {
        $sql = 'SELECT users.user_id, CONCAT(first_name, " ", last_name) AS fullname , users.username, users.tag_name, users.email, users.bio, users.avatar, users.created_at
                FROM users
                WHERE tag_name = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tag_name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchEditingInfo($user_id)
    {
        $sql = 'SELECT users.user_id, users.first_name, users.last_name, users.username, users.tag_name, users.email, users.bio, users.avatar, users.created_at
                FROM users
                WHERE user_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchSocialLinks($user_id)
    {
        $sql = 'SELECT user_social_links.platform, user_social_links.url FROM user_social_links
                INNER JOIN users ON user_social_links.user_id = users.user_id
                WHERE users.user_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllModules()
    {
        $sql = "SELECT * FROM modules";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchUserByUsername($username)
    {
        $sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS fullname, username, password, avatar, tag_name, role_id FROM users WHERE BINARY username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRememberToken($user_id, $token)
    {
        $sql = "UPDATE users SET remember_token = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token, $user_id]);
    }

    public function clearRememberToken($user_id)
    {
        $sql = "UPDATE users SET remember_token = NULL WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
    }

    public function checkEmailExists($email)
    {
        $sql = "SELECT user_id FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function insertUser($firstName, $lastName, $username, $tagName, $email, $password)
    {
        $sql = "INSERT INTO users (first_name, last_name, username, tag_name, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $username, $tagName, $email, $password]);
    }

    public function fetchTagsByType($type)
    {
        $sql = 'SELECT tag_name, tag_description
                FROM tags
                WHERE tag_type = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllTags()
    {
        $sql = 'SELECT * FROM tags';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLikesCount($post_id)
    {
        $sql = 'SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        $like = $stmt->fetch();

        return $like;
    }


    public function getCommentsCount($post_id)
    {
        $sql = 'SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        $comment = $stmt->fetch();

        return $comment;
    }

    public function checkLikes($post_id)
    {
        $sqlSelect = 'SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?';
        $stmt = $this->pdo->prepare($sqlSelect);
        $stmt->execute([$_SESSION['user_id'], $post_id]);
        $isLiked = $stmt->fetch(PDO::FETCH_ASSOC);

        return $isLiked;
    }

    public function handleLikes($isLiked, $post_id)
    {
        if ($isLiked) {
            $sqlDelete = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
            $stmtDelete = $this->pdo->prepare($sqlDelete);
            $stmtDelete->execute([$_SESSION['user_id'], $post_id]);

            return true;
        } else {
            $sqlInsert = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);
            $stmtInsert->execute([$_SESSION['user_id'], $post_id]);

            return false;
        }
    }

    public function checkSavedPosts($post_id)
    {
        $sqlSelect = "SELECT 1 FROM user_saved_posts WHERE user_id = ? AND post_id = ?";
        $stmtSelect = $this->pdo->prepare($sqlSelect);
        $stmtSelect->execute([$_SESSION['user_id'], $post_id]);
        $savedPost = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        return $savedPost;
    }

    public function handleSavedPosts($isSaved, $post_id)
    {
        if ($isSaved) {
            $sqlDelete = "DELETE FROM user_saved_posts WHERE user_id = ? AND post_id = ?";
            $stmtDelete = $this->pdo->prepare($sqlDelete);
            $stmtDelete->execute([$_SESSION['user_id'], $post_id]);

            return true;
        } else {
            $sqlInsert = "INSERT INTO user_saved_posts (user_id, post_id) VALUES (?, ?)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);
            $stmtInsert->execute([$_SESSION['user_id'], $post_id]);

            return false;
        }
    }

    public function getAllSavedPosts()
    {
        $sql = 'SELECT user_saved_posts.user_id AS user_savedid,posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.created_at, posts.imageURL, users.avatar, users.username, modules.module_id, modules.module_name, modules.bg_class, modules.text_class FROM (((posts
        INNER JOIN user_saved_posts ON posts.post_id = user_saved_posts.post_id)
        INNER JOIN users ON posts.user_id = users.user_id)
        INNER JOIN modules ON posts.module_id = modules.module_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllUsers($userId)
    {
        $sql = 'SELECT user_id, CONCAT(first_name, " ", last_name) AS fullname, username, tag_name, avatar, bio FROM users
                WHERE user_id <> ?
        ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function checkSearchValue($query)
    {
        if ($query[0] === '#') {
            $sqltags = "SELECT DISTINCT 'tag' AS type, tags.tag_name FROM tags WHERE tags.tag_name LIKE ?";
            $stmt = $this->pdo->prepare($sqltags);
            $stmt->execute(['%' . substr($query, 1) . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [['type' => 'tag', 'tag_name' => '']];
        } elseif ($query[0] === '@') {
            $sqlusers = "SELECT DISTINCT 'user' AS type, users.tag_name FROM users WHERE users.tag_name LIKE ?";
            $stmt = $this->pdo->prepare($sqlusers);
            $stmt->execute(['%' . substr($query, 1) . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [['type' => 'user', 'tag_name' => '']];
        } else {
            $sqltitle = "SELECT 'title' AS type, posts.post_title FROM posts WHERE posts.post_title LIKE ?";
            $stmt = $this->pdo->prepare($sqltitle);
            $stmt->execute(['%' . $query . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [['type' => 'title', 'post_title' => '']];
        }
    }


    public function searchPostsAndUsers($query)
    {
        $sql = "
        SELECT 'title' AS type, posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.created_at, posts.imageURL, users.avatar, users.username, modules.module_id, modules.module_name, modules.bg_class, modules.text_class
        FROM ((((posts 
        INNER JOIN users ON posts.user_id = users.user_id)
        INNER JOIN modules ON posts.module_id = modules.module_id)
        LEFT JOIN likes ON posts.post_id = likes.post_id)
        LEFT JOIN comments ON posts.post_id = comments.post_id)
        WHERE posts.post_title LIKE :query
        GROUP BY posts.post_id
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchPostByTags($query)
    {
        $stmt = $this->pdo->prepare("
        SELECT DISTINCT 'tag' AS type, tags.tag_name, posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.created_at, posts.imageURL, users.avatar, users.username, modules.module_id, modules.module_name, modules.bg_class, modules.text_class
        FROM ((((posts 
        INNER JOIN posttags ON posts.post_id = posttags.post_id)
        INNER JOIN tags ON posttags.tag_id = tags.tag_id)
        INNER JOIN users ON posts.user_id = users.user_id)
        INNER JOIN modules ON posts.module_id = modules.module_id)
        WHERE tags.tag_name LIKE :query
        GROUP BY posts.post_id
    ");
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchPostByTagName($query)
    {
        $stmt = $this->pdo->prepare("
        SELECT DISTINCT 'user' AS type, users.tag_name, posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.created_at, posts.imageURL, users.avatar, users.username, modules.module_id, modules.module_name, modules.bg_class, modules.text_class
        FROM ((((posts 
        INNER JOIN users ON posts.user_id = users.user_id)
        INNER JOIN modules ON posts.module_id = modules.module_id)
        LEFT JOIN likes ON posts.post_id = likes.post_id)
        LEFT JOIN comments ON posts.post_id = comments.post_id)
        WHERE users.tag_name LIKE :query
        GROUP BY posts.post_id
    ");
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReadingHistory($userId, $postId)
    {
        $sql = "INSERT INTO reading_history (user_id, post_id, read_date) VALUES (:user_id, :post_id, CURDATE())
            ON DUPLICATE KEY UPDATE read_date = CURDATE()";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
    }

    public function getReadingHistory($userId)
    {
        $sql = "SELECT posts.*, users.avatar, users.tag_name, reading_history.read_date FROM ((reading_history
                JOIN posts ON reading_history.post_id = posts.post_id)
                JOIN users ON posts.user_id = users.user_id)
                WHERE reading_history.user_id = :user_id
                ORDER BY reading_history.read_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function followUser($followerId, $followingId)
    {
        $sql = "INSERT INTO user_follows (follower_id, following_id) VALUES (:follower_id, :following_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['follower_id' => $followerId, 'following_id' => $followingId]);
    }

    public function unfollowUser($followerId, $followingId)
    {
        $sql = "DELETE FROM user_follows WHERE follower_id = :follower_id AND following_id = :following_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['follower_id' => $followerId, 'following_id' => $followingId]);
    }

    public function getFollowerCount($userId)
    {
        $sql = "SELECT COUNT(*) FROM user_follows WHERE following_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn();
    }

    public function getFollowingCount($userId)
    {
        $sql = "SELECT COUNT(*) FROM user_follows WHERE follower_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn();
    }

    public function isFollowing($followerId, $followingId)
    {
        $sql = "SELECT COUNT(*) FROM user_follows WHERE follower_id = :follower_id AND following_id = :following_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['follower_id' => $followerId, 'following_id' => $followingId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getTotalLikeCount($userId)
    {
        $sql = "SELECT COUNT(*) FROM likes 
                INNER JOIN posts ON likes.post_id = posts.post_id 
                WHERE posts.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn();
    }

    public function getTotalViewCount($userId)
    {
        $sql = "SELECT SUM(view_count) FROM posts WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn();
    }

    public function incrementViewCount($postId, $userId)
    {
        // Check if the user has already viewed the post
        $sql = "SELECT COUNT(*) FROM post_views WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        $viewed = $stmt->fetchColumn();

        if ($viewed == 0) {
            // Increment view count
            $sql = "UPDATE posts SET view_count = view_count + 1 WHERE post_id = :post_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['post_id' => $postId]);

            // Add view record
            $sql = "INSERT INTO post_views (user_id, post_id) VALUES (:user_id, :post_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        }
    }

    public function sendNotifications($userId, $senderId, $type, $message, $message_content, $url)
    {
        $sql = 'INSERT INTO notifications (user_id, sender_id, type , message, message_content, url) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $senderId, $type, $message, $message_content, $url]);
    }

    public function getAllNotifications($userId)
    {
        $sql = "SELECT notifications.*, users.avatar, users.username 
                FROM notifications
                INNER JOIN users ON notifications.sender_id = users.user_id
                WHERE notifications.user_id = ?
                ORDER BY notifications.created_at DESC
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAllNotificationsAsRead($userId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
    }

    public function markNotificationAsRead($notificationId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$notificationId]);
    }

    public function deleteAllNotification($user_id)
    {
        $sql = "DELETE FROM notifications WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
    }

    public function deleteNotification($notificationId)
    {
        $sql = 'DELETE FROM notifications WHERE notification_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$notificationId]);
    }

    public function editComment($content, $comment_id)
    {
        $sql = "UPDATE comments SET content = ? WHERE comment_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$content, $comment_id]);
    }

    public function deleteComment($comment_id)
    {
        $sql = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$comment_id]);
    }

    public function getAllFollowers($following_id)
    {
        $sql = "SELECT users.user_id, users.avatar, users.tag_name, CONCAT(users.first_name, ' ', users.last_name) AS fullname
        FROM users INNER JOIN user_follows ON users.user_id = user_follows.follower_id
        WHERE user_follows.following_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$following_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFollowing($follower_id)
    {
        $sql = "SELECT users.avatar, users.tag_name, CONCAT(users.first_name, ' ', users.last_name) AS fullname
        FROM users INNER JOIN user_follows ON users.user_id = user_follows.following_id
        WHERE user_follows.follower_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$follower_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($userId, $currentPassword)
    {
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($currentPassword, $result['password'])) {
            return true;
        }
        return false;
    }

    public function changePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$hashedPassword, $userId]);
    }


    // Admin Functions
    public function getUsersFromAdmin()
    {
        $sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS fullname, username, tag_name, email, avatar, role_id, created_at FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUsers($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
    }

    public function getModulesFromAdmin($module_array)
    {
        if (!empty($module_array)) {
            $placeholders = implode(',', array_fill(0, count($module_array), '?'));
            $sql = "SELECT modules.*, COUNT(posts.module_id) AS post_using FROM modules
                    LEFT JOIN posts ON posts.module_id = modules.module_id
                    WHERE modules.module_name IN ($placeholders)
                    GROUP BY modules.module_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($module_array);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getModuleByName($module_name)
    {
        $sql = "SELECT * FROM modules WHERE module_name = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$module_name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addModulesFromAdmin($module_name, $bg_class, $text_class)
    {
        $sql = "INSERT INTO modules (module_name, bg_class, text_class)
                VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$module_name, $bg_class, $text_class]);
    }

    public function updateModulesFromAdmin($module_id, $module_name, $bg_class, $text_class)
    {
        $sql = "UPDATE modules SET module_name = ?, bg_class = ?, text_class = ? WHERE module_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$module_name, $bg_class, $text_class, $module_id]);
    }

    public function deleteModulesFromAdmin($module_id, $module_post_count)
    {
        if ($module_post_count > 0) {
            // Update posts to have module_id as 0 (Uncategorized)
            $updateSql = "UPDATE posts SET module_id = 0 WHERE module_id = ?";
            $updateStmt = $this->pdo->prepare($updateSql);
            $updateStmt->execute([$module_id]);
        }

        // Delete the module
        $deleteSql = "DELETE FROM modules WHERE module_id = ?";
        $deleteStmt = $this->pdo->prepare($deleteSql);
        $deleteStmt->execute([$module_id]);
    }
}
