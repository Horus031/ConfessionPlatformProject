<?php
    include '../includes/configcloud.php';
    use Cloudinary\Api\Upload\UploadApi;

    if (isset($_FILES['avatarURL']) && $_FILES['avatarURL']['tmp_name']) {
        try {
            $upload = (new UploadApi())->upload($_FILES['avatarURL']['tmp_name'], [
                'folder' => 'avatars',
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill' // Resize and crop the image to fit the specified dimensions
                ]
            ]);

            // Get the image URL from Cloudinary
            $avatarURL = $upload['secure_url'];
        } catch (Exception $e) {
            echo 'error' . $e->getMessage();
        }
    } else {
        echo 'error' . 'No avatar found';
    }
?>