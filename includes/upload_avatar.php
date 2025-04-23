<?php
include '../includes/configcloud.php';

use Cloudinary\Api\Upload\UploadApi;

if (isset($_FILES['avatarURL']) && $_FILES['avatarURL']['tmp_name']) {
    try {
        $upload = (new UploadApi())->upload($_FILES['avatarURL']['tmp_name'], [
            'folder' => 'avatars',
            'transformation' => [
                'width' => 1920,
                'height' => 1080,
                'crop' => 'limit',
                'quality' => 'auto', // Automatically adjust the quality
                'fetch_format' => 'auto' // Automatically adjust the format
            ]
        ]);

        // Get the image URL from Cloudinary
        $avatarURL = $upload['secure_url'];
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No avatar found']);
}
