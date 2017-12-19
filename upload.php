<?php

function uploadImage($file) {
    $uploaddir = '/uploads/';
    $filename = uniqid() . '-' . basename($file['name']);
    $uploadfile = __DIR__ . $uploaddir . $filename;
    $fileType = pathinfo($uploadfile,PATHINFO_EXTENSION);

    if($fileType !== 'jpg' && $fileType != 'png' && $fileType !== 'jpeg' && $fileType !== 'gif') {
        return false;
    }

    if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
        return $filename;
    } else {
        return false;
    }
}