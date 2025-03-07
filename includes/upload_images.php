<?php
    include '../includes/configcloud.php';
    use Cloudinary\Api\Upload\UploadApi;

    if ($_FILES['imageURL']['tmp_name']) {
        try {
            $upload = (new UploadApi())->upload($_FILES['imageURL']['tmp_name'], [
                'folder' => 'posts', // Lưu hình vào folder trên Cloudinary
                'transformation' => [
                    'width' => 320,
                    'height' => 200,
                    'crop' => 'fill'
                ]
            ]);

            // Lấy URL từ Cloudinary
            $imageUrl = $upload['secure_url'];

        } catch (Exception $e) {
            echo 'error' . $e->getMessage();
        }
    } else {
        echo 'error' . 'No image uploaded';
    }
?>