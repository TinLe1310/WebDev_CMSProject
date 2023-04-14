<?php

/*******w******** 
    
    Name: Tin Le
    Date: 04/12/2023
    Description: Upload file

****************/
require 'ImageResize.php';
require 'ImageResizeException.php';

$allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
$allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];


function file_upload_path($original_file, $upload_subfolder='uploads'){
    $current_folder = dirname(__FILE__);

    $path_segments = [$current_folder, $upload_subfolder, basename($original_file)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

$file_upload_detected = isset($_FILES['uploaded_file']) && ($_FILES['uploaded_file']['error'] === 0);
$error_detected = isset($_FILES['uploaded_file']) && ($_FILES['uploaded_file']['error'] > 0);

if($file_upload_detected){
    $original_filename = $_FILES['uploaded_file']['name'];
    $temp_filename = $_FILES['uploaded_file']['tmp_name'];
    $new_file_path = file_upload_path($original_filename);
    
    $actual_file_extension = pathinfo($new_file_path, PATHINFO_EXTENSION);
    $actual_mime_type = mime_content_type($temp_filename);

    $file_upload_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_valid = in_array($actual_mime_type, $allowed_mime_types);

    if($file_upload_valid && $mime_type_valid){
        move_uploaded_file($temp_filename, $new_file_path);
        header("Location: choose_image.php");    
    } else {
        echo 'Error! Your file is not a valid type.';
    }

    if(in_array($actual_mime_type, ['image/gif', 'image/jpeg', 'image/png'])){
    
    $image_filepath = 'uploads/' . $original_filename;
    
    $resized_image_filename = 'uploads' . DIRECTORY_SEPARATOR . 
                        pathinfo($original_filename, PATHINFO_FILENAME) . '.' . pathinfo($original_filename, PATHINFO_EXTENSION);

    $image_filepath = new \Gumlet\ImageResize($image_filepath);
    $image_filepath->resizeToBestFit(240, 300);
    $image_filepath->save($resized_image_filename);
    }

    
}
?>