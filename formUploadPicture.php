<!--Nicho-->
<form id="uploadProfilePic" action=<?php echo '"srcUploadPicture.php?Username=' .  $_GET['Username'] .'"' ?> enctype="multipart/form-data" method="post">
    <h2>Change profilepic</h2>
    <!-- Optioneel
    <p>
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
    </p>-->
    <p>
        <input id="file" type="file" name="image" />
    </p>
    <p>
        <input id="submit" type="submit" name="submit" value="Upload" />
    </p>
</form>