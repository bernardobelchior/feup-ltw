<?php
session_start(['cookie_httponly' => true]);

include_once('../utils/utils.php');
include_once('../../database/users.php');
require_once('../utils/ImageManipulator.php');

// If the user didn't come from a valid page.
if ($_SESSION['token'] !== $_POST['token']) {
    header('HTTP/1.0 403 Forbidden');
    header('Location: ../index.php?page=403.html');
    die();
}

$id = htmlspecialchars($_POST['id']);

$_SESSION['token'] = generateRandomToken();
$_POST['token'] = $_SESSION['token'];
if (!$_FILES['photo']['name']) {
    echo 'No file uploaded.';
    header('Location: ../index.php?page=edit_profile.php');
    die();
}

if ($_FILES['photo']['error']) {
    echo 'Error uploading';
    header('Location: ../index.php?page=edit_profile.php');
    die();
}

foreach($_FILES as $file){
    $validExtensions = array('.jpg', '.png', '.jpeg');
    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

    if(!in_array($extension,$validExtensions)){
        echo 'Invalid file type';
        break;
    }

    $manipulator = new ImageManipulator($file['tmp_name']);
    $width = $manipulator->getWidth();
    $height = $manipulator->getHeight();
    $centerX = round($width/2);
    $centerY = round($height/2);


//    //for 32x32 img
//    $newNamePrefix = time().'_32_';
//    $x1_32 = $centerX - 16;
//    $y1_32 = $centerY - 16;
//
//    $x2_32 = $centerX + 16;
//    $y2_32 = $centerY + 16;
//
//    $newImage = $manipulator->crop($x1_32,$y1_32, $x2_32, $y2_32);
//    $picturePath = $newNamePrefix.$file['name'];
//    $manipulator->save($picturePath);
//
//    //for 64x64 img
//    $x1_64 = $centerX - 32;
//    $y1_64 = $centerY - 32;
//
//    $x2_64 = $centerX + 32;
//    $y2_64 = $centerY + 32;
//
//    $newNamePrefix = time().'_64_';
//    $newImage = $manipulator->crop($x1_64,$y1_64, $x2_64, $y2_64);
//    $picturePath = $newNamePrefix.$file['name'];
//    $manipulator->save($picturePath);

    //for 256x256 img
    $x1_256 = $centerX - 128;
    $y1_256 = $centerY - 128;

    $x2_256 = $centerX + 128;
    $y2_256 = $centerY + 128;

    $newNamePrefix = '256_';
    $newImage = $manipulator->crop($x1_256,$y1_256, $x2_256, $y2_256);
    $picturePath = 'profile_pictures/'.$newNamePrefix.$id;
    $manipulator->save('../../'.$picturePath);
}


//$picturePath = 'profile_pictures/' . $id . '.' . $extension;
//move_uploaded_file($_FILES['photo']['tmp_name'], '../../' . $picturePath);
var_dump(changeProfilePicture($id, $picturePath));
var_dump(getUserField($id, 'Picture'));

die();
header('Location: ../index.php?page=profile.php&id=' . $id);
die();
