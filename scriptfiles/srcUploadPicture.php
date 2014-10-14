<?php
    include_once 'srcGetProfile.php';
    $targetPath = "userFiles/". $data['UserName'];
    //$target_path = $target_path . basename($_FILES['file']['name']);
    if (!(file_exists($targetPath))){
        echo $targetPath;
        mkdir($targetPath);
    }
    
    $path = $_FILES['image']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    
    if($ext !== 'jpg'){
        echo 'Only jpg allowed!';
    } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath . '/profilePic.jpg')){
        echo "The file " . basename($_FILES['image']['name']) . " has been uploaded";
    } else {
        echo "Failed to upload file, please try again!";            
    }
?>