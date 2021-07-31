<?php
class Api
{
    private $media_list = [];
    public function __construct($media_list) {
        $this->media_list = $media_list;
    }

    public function getImage($name) {
        if (array_key_exists($name, array_flip($this->media_list))) {
            $response = [
                "message" => "this is api",
                "status" => true,
                "url" => "http://localhost/media/$name"
            ];
        }
        else {
            $response = [
                "status" => false,
                "message" => "image does not exists"
            ];
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function uploadImage() {
        global $base;
        $upload_ok = false;
        $message = "File not uploaded";

        if (isset($_POST["submit"]) && isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
            $target_dir = $base . "/private/media/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $message = '';

            $response = $this->uploadValidation($target_file);
            $message .= $response['message'];
            $upload_ok = $response['status'];

            if (file_exists($target_file)) {
                $message .= "Sorry, file already exists.";
                $upload_ok = false;
            }
            
            if ($_FILES["fileToUpload"]["size"] > 50000000) {
                $message .= "Sorry, your file is too large.";
              $upload_ok = false;
            }
            
            if($image_file_type != "jpg" && $image_file_type != "jpeg") {
                $message .= "Sorry, only JPG, JPEG files are allowed.";
              $upload_ok = false;
            }

            $file_name_parts = explode('.', $target_file);
            $file_path = $file_name_parts[0] . '.jpeg';

            if ($upload_ok === false) {
                $message .= "Sorry, your file was not uploaded.";
            } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_path)) {
                $message .= "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              } else {
                $message .= "Sorry, there was an error uploading your file.";
                $upload_ok = false;
              }
            }
        }

        $response = [
            "status" => $upload_ok,
            "message" => $message
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    private function uploadValidation($target_file) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $message = '';
        if ($check !== false) {
            $message .= "File is an image - " . $check["mime"] . ".";
            $upload_ok = true;
        } else {
            $message .= "File is not an image.";
            $upload_ok = false;
        }
        return [
            "status" => $upload_ok,
            "message" => $message
        ];
    }
}
