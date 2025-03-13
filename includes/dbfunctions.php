<?php
class Database {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchExistingImageURL($post_id) {
        $sql = "SELECT imageURL FROM posts WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        $existingPost = $stmt->fetch(PDO::FETCH_ASSOC);
        return $existingPost['imageURL'];
    }

    public function insertPost($user_id, $title, $content, $module_id, $imageURL) {
        $sql = 'INSERT INTO posts (user_id, post_title, post_content, module_id, imageURL, status) VALUES (?, ?, ?, ?, ?, "approved")';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $title, $content, $module_id, $imageURL]);
        return $this->pdo->lastInsertId();
    }

    public function fetchTagIds($tagArray) {
        if (!empty($tagArray)) {
            $placeholders = implode(',', array_fill(0, count($tagArray), '?'));
            $sql = "SELECT tag_id FROM tags WHERE tag_name IN ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($tagArray);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        return [];
    }

    public function insertPostTags($post_id, $tagIds) {
        $sql = "INSERT INTO posttags (post_id, tag_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($tagIds as $tag_id) {
            $stmt->execute([$post_id, $tag_id]);
        }
    }

    public function updatePost($post_id, $title, $content, $module_id, $imageURL) {
        $sql = "UPDATE posts SET
                post_title = ?,
                post_content = ?,
                module_id = ?,
                imageURL = ?
                WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$title, $content, $module_id, $imageURL, $post_id]);
    }

    public function deleteExistingTags($post_id) {
        $sql = "DELETE FROM posttags WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
    }

    public function deletePost($post_id) {
        $sql = "DELETE FROM posts WHERE post_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
    }

    public function insertNewTags($post_id, $tagArray) {
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

    public function fetchExistingAvatarURL($user_id) {
        $sql = "SELECT avatar FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        return $existingUser['avatar'];
    }

    public function updateUser($user_id, $username, $tag_name, $email, $avatarURL, $bio) {
        $sql = "UPDATE users SET
                username = ?,
                tag_name = ?,
                email = ?,
                avatar = ?,
                bio = ?
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $tag_name, $email, $avatarURL, $bio, $user_id]);
    }

    public function updateUserSocialLinks($user_id, $social_links) {
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

    public function fetchComments($post_id) {
        $sql = 'SELECT comments.comment_id, comments.user_id, comments.post_id, comments.content, users.username, users.avatar
                FROM ((comments
                INNER JOIN posts ON comments.post_id = posts.post_id)
                INNER JOIN users ON comments.user_id = users.user_id)
                WHERE posts.post_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchPostDetails($post_id) {
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

    public function fetchPostTagsWithId($post_id) {
        $sql = 'SELECT tags.tag_id, tags.tag_name, tags.tag_description, tags.tag_type
                FROM tags
                JOIN posttags ON tags.tag_id = posttags.tag_id
                WHERE posttags.post_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllPostTags() {
        $sql = "SELECT posts.post_id, posts.post_title, tags.tag_id, tags.tag_name, tags.tag_description, tags.tag_type
                FROM posts
                JOIN posttags ON posts.post_id = posttags.post_id
                JOIN tags ON tags.tag_id = posttags.tag_id
                ORDER BY tag_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllPosts() {
        $sql = 'SELECT posts.post_id, posts.user_id, posts.post_title, posts.post_content, posts.created_at, posts.imageURL, users.avatar, users.username, COUNT(DISTINCT likes.like_id) as likes, COUNT(DISTINCT comments.comment_id) as comments, modules.module_id, modules.module_name, modules.bg_class, modules.text_class 
                FROM ((((posts 
                INNER JOIN users ON posts.user_id = users.user_id)
                INNER JOIN modules ON posts.module_id = modules.module_id)
                LEFT JOIN likes ON posts.post_id = likes.post_id)
                LEFT JOIN comments ON posts.post_id = comments.post_id)
                GROUP BY post_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchUserInfo($user_id) {
        $sql = 'SELECT users.username, users.tag_name, users.email, users.bio, users.avatar, users.created_at, user_social_links.platform, user_social_links.url
                FROM users
                LEFT JOIN user_social_links ON users.user_id = user_social_links.user_id
                WHERE users.user_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllModules() {
        $sql = "SELECT * FROM modules";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchUserByUsername($username) {
        $sql = "SELECT user_id, password, avatar FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRememberToken($user_id, $token) {
        $sql = "UPDATE users SET remember_token = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token, $user_id]);
    }

    public function clearRememberToken($user_id) {
        $sql = "UPDATE users SET remember_token = NULL WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
    }

    public function checkUsernameExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetchColumn();
    }

    public function registerUser($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $hash]);
    }

    public function fetchTagsByType($type) {
        $sql = 'SELECT tag_name, tag_description
                FROM tags
                WHERE tag_type = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllTags() {
        $sql = 'SELECT * FROM tags';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function handleLikes($post_id) {
        $sqlSelect = 'SELECT likes.like_id, likes.user_id, likes.post_id FROM likes
                INNER JOIN posts ON likes.post_id = posts.post_id
                WHERE posts.post_id = ?';
        $stmt = $this->pdo->prepare($sqlSelect);
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>