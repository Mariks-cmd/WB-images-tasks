<?php

$base = dirname(__DIR__);

define('DEBUG_MODE', true);
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function mediaPath($filename) {
    global $base;
    return $base . '/private/media/' . $filename . '.jpeg';
}

$array = scandir($base . "/private/media");

$media_list = [];

foreach ($array as $key => $value) {
    $full_name_parts = explode('.', $value);
    if ($full_name_parts[0] != '') {
        $media_list[] = $full_name_parts[0];
    }
}

$image_name = $media_list[0];

if (isset($_GET['entrypoint'])) {
    if ($_GET['entrypoint'] == 'media') {
        include $base . "/private/class_media.php";
        $image = new media();

        if (
            isset($_GET['name']) &&
            is_string($_GET['name']) &&
            array_key_exists($_GET['name'], array_flip($media_list))
        ) {
            $image_name = $_GET['name'];
        }
       
        $image->show(mediaPath($image_name));
    }
    elseif ($_GET['entrypoint'] == 'api') {
        header('Content-type: application/json');
        include $base. "/private/class_api.php";
        $api = new Api($media_list);
        if (isset($_GET['name'])) {
            if ($_GET['name'] == 'get_image') {
                if (isset($_POST['main_image_name']) && is_string($_POST['main_image_name'])) {
                    $api->getImage($_POST['main_image_name']);
                }
            }
            elseif($_GET['name'] == 'upload') {
                $api->uploadImage();
            }

        }
       

    }
    elseif ($_GET['entrypoint'] == 'upload') {
        include $base. "/private/views/upload_form.php";
    }
}
else {
    $image_name = "resized-image-Promo_1";
    include $base. "/private/views/gallery_head.php";
    include $base. "/private/views/main_image.php";
    include $base. "/private/views/gallery.php";
    include $base. "/private/views/gallery_footer.php";
}

?>