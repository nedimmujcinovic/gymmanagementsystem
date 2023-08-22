<?php

$photo = $_FILES['photo'];

$photo_name = basename($photo['name']);

$photo_path = 'member_photos/' . $photo_name;

$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

$ext = pathinfo($photo_name, PATHINFO_EXTENSION);

    if(
        in_array($ext, $allowed_ext) && $photo['size'] < 20000000 ) {
            move_uploaded_file($photo['tmp_name'], $photo_path);
            
            echo json_encode(['success' => true, 'photo_path' => $photo_path]);
        }
        else {
            echo json_encode(['success' => false, 'error' => 'Invalid file']);
        }
    



?>
 
<!-- {

array(6) { ["name"]=> string(36) 
    "pexels-anna-nekrashevich-8993561.jpg" 
    ["full_path"]=> string(36)
     "pexels-anna-nekrashevich-8993561.jpg" 
     ["type"]=> string(10) "image/jpeg" 
     ["tmp_name"]=> string(24) 
     "C:\xampp\tmp\phpD11B.tmp" ["error"]=> int(0) 
     ["size"]=> int(3484639) }
} -->