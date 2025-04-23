<?php
include '../includes/configcloud.php';

use Cloudinary\Api\Upload\UploadApi;

if (isset($_FILES['imageURL']['tmp_name']) && is_uploaded_file($_FILES['imageURL']['tmp_name'])) {
    try {
        $upload = (new UploadApi())->upload($_FILES['imageURL']['tmp_name'], [
            'folder' => 'posts', // Save the image in the folder on Cloudinary
            'transformation' => [
                'width' => 1920, // Higher width for better quality
                'height' => 1080, // Higher height for better quality
                'crop' => 'limit', // Ensure the image fits within the dimensions without cropping
                'quality' => 'auto', // Automatically adjust the quality
                'fetch_format' => 'auto', // Automatically adjust the format
            ],
        ]);

        // Get the URL from Cloudinary
        $imageUrl = $upload['secure_url'];
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['error' => 'No image uploaded']);
    exit;
}
