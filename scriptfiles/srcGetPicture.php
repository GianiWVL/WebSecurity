<?php
    if (isset($data['UserName'])){
        $filename = 'UserFiles/' . $data['UserName'];
        $user = $data['UserName'];
    }
    if (isset($rowUser['UserName'])){
        $filename = 'UserFiles/' . $rowUser['UserName'];
        $user = $rowUser['UserName'];
    }
    
    if (file_exists($filename)) {
        //echo "<img id='profilePic' src='" . $filename . "/profilePic.jpg'/>";
        echo "<a href='profiel.php?Username=" . $user . "' class='userlink'><img id='profilePic' src='" . $filename . "/profilePic.jpg'/></a>";
    } else {
        echo "<a href='profiel.php?Username=" . $user . "' class='userlink'><img id='profilePic' src='UserFiles/profilePic.jpg'/profilePic.jpg'/></a>";
        //echo '<img id="profilePic" src="UserFiles/profilePic.jpg"/>';
    }
?>