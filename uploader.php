<?php
	$target_path = "afbeeldingen/";
	$namePicture = "profilePic";
	//$target_path = $target_path . basename($_FILES['file']['name']);
        $target_path = $target_path . "profilePic";
	echo $target_path;
	if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)){
            echo "The file " . basename($_FILES['file']['name']) . " has been uploaded";
        } else {
            echo "Failed to upload file, please try again!";            
        }
?>