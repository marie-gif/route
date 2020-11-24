<?php
$ok=false;
$uploadOk = true;

$target_dir = "public/img/";

$filename = basename($files["name"]);

$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));

$target_file = $target_dir . 'img'.$id.'.' . $imageFileType;

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $message = "Sorry, only JPG, JPEG, PNG and GIF files are allowed.";
  array_push($messages,$message);
  $uploadOk = false;
}

// Check file size
if ($files["size"] > 8000000) {
  $message = "Sorry, your file is too large.";
  array_push($messages,$message);
  $uploadOk = false;
}

if($uploadOk)
if (move_uploaded_file($files["tmp_name"], $target_file)) {
  $message = "The file ". basename( $files["name"]). " has been uploaded.";
  array_push($messages,$message);
  $ok=true;
} else {
  $message = "Sorry, there was an error uploading your file.";
  array_push($messages,$message);
}

