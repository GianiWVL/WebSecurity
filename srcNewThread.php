<?php
include_once "DBConnect.php";
include_once "loginCheck.php";
if($dbh->connect_errno){
    echo "Failed to connect to database. Error: " . $dbh->connect_error;
    die();
}else{
    if ($_POST['captcha'] == $_SESSION['captchaResult'])
    {
        $message = $dbh->real_escape_string(htmlentities($_POST['txtSendMessage']));
        $title = $dbh->real_escape_string(htmlentities($_POST['txtThreadTitle']));
        if (strlen($message) > 0 && strlen($title) > 0)
        {
            $cat = $_SESSION['currentCat'];
            var_dump($cat);

            $clientip = $_SERVER['REMOTE_ADDR'];

            global $title;

            date_default_timezone_set("Europe/Brussels");
            $DateTime = date("Y-m-d H:i:s", time());

            $username = $_SESSION['Logged'];
            $resultUserId = mysqli_query($dbh, "SELECT UserID FROM tblusers WHERE UserName='".htmlentities($username)."'");
            $resUserID = mysqli_fetch_array($resultUserId);

            //ADD THREAD
            $sql = "INSERT INTO `honeypot`.`tblthreads` (`ThreadID`, `CategorieID`, `Title`, `DateTime`, `UserID`, `LastEdited`, `LastEditedUserID`) VALUES (NULL, '".htmlentities($cat)."', '".htmlentities($title)."', '".htmlentities($DateTime)."', '".htmlentities($resUserID['UserID'])."', '".htmlentities($DateTime)."', '".htmlentities($resUserID['UserID'])."')";
            $result = mysqli_query($dbh, $sql);

            var_dump($sql);
            $resultNewThreadId = mysqli_query($dbh, "SELECT MAX(ThreadID) FROM tblThreads");
            $resNewThreadID = mysqli_fetch_array($resultNewThreadId);
            $newThreadID = $resNewThreadID[0];

            if ($newThreadID == NULL) {
                $newThreadID = 1;
            }

            //ADD MESSAGE TO NEW THREAD
            $sql = "INSERT INTO `honeypot`.`tblMessages` (`ID`, `PostID`, `Body`, `UserID`, `ThreadID`, `DateTime`, `PostIP`) VALUES (NULL, '1', '".htmlentities($message)."', '".htmlentities($resUserID['UserID'])."', '".htmlentities($newThreadID)."', '".htmlentities($DateTime)."', '".htmlentities($clientip)."')";
            $result = mysqli_query($dbh, $sql);

            header("Location: showthread.php?cat=".htmlentities($_SESSION['currentCat'])."&thread=".htmlentities($newThreadID)."&page=1#1");
        } else {
            header("Location: showthread.php?cat=".htmlentities($_SESSION['currentCat'])."&thread=".htmlentities($newThreadID)."&page=1");

        }
    } else {
        header("Location: showthread.php");

    }

}
?>