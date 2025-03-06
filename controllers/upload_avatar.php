<?php
    include '../includes/configcloud.php';
    use Cloudinary\Api\Upload\UploadApi;

    if ($_FILES['image']['tmp_name']) {
        try {
            $upload = (new UploadApi())->upload($_FILES['image']['tmp_name'], [
                'folder' => 'avatars',
                'width' => 200,  // Resize về 200px
                'height' => 200,
                'crop' => 'fill' // Cắt ảnh vừa khung
            ]);
        
            // Get the image URL from Cloudinary
            $imageUrl = $upload['secure_url'];
        } catch (Exception $e) {
            echo 'error' . $e->getMessage();
        }
    } else {
        echo 'error' . 'No avatar found';
    }
?>