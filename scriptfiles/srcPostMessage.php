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
        if (strlen($message) > 0)
        {
            $username = $_SESSION['Logged'];
            $currentThread = $_SESSION['currentThread'];
            date_default_timezone_set("Europe/Brussels");
            $DateTime = date("Y-m-d H:i:s", time());
            $clientip = $_SERVER['REMOTE_ADDR'];

            $maxPostID = mysqli_query($dbh, "SELECT MAX(PostID) FROM tblmessages WHERE ThreadID='".$currentThread."'");
            $maxPost = mysqli_fetch_array($maxPostID);
            if ($maxPost[0] == NULL) {
                $maxPost[0] = 1;
            } else {
                $maxPost[0] = $maxPost[0] + 1;
            }

            $resultUserId = mysqli_query($dbh, "SELECT UserID FROM tblusers WHERE UserName='".htmlentities($username)."'");
            $resUserID = mysqli_fetch_array($resultUserId);



            if($resUserID['UserID'] != '')
            {
                global $maxPost;
                global $currentThread;
                $sqlInsert = "INSERT INTO `honeypot`.`tblMessages` (`ID`, `PostID`, `Body`, `UserID`, `ThreadID`, `DateTime`, `PostIP`) VALUES (NULL, ".htmlentities($maxPost[0]).", '".htmlentities($message)."', '".htmlentities($resUserID['UserID'])."', '".htmlentities($currentThread)."', '".htmlentities($DateTime)."', '".htmlentities($clientip)."')";
                $result = mysqli_query($dbh, $sqlInsert);

                $sqlUpdate = "UPDATE tblthreads SET LastEdited='".$DateTime."' WHERE ThreadId='".$currentThread."'";
                var_dump($sqlUpdate);
                $result = mysqli_query($dbh, $sqlUpdate);

                $sqlUpdate = "UPDATE tblthreads SET LastEditedUserID='".htmlentities($resUserID['UserID'])."' WHERE ThreadId='".$currentThread."'";
                var_dump($sqlUpdate);
                $result = mysqli_query($dbh, $sqlUpdate);

                //DELETE Viewed Users
                $sqlDelete = "DELETE FROM tblviewedthreads WHERE ThreadID = '".$currentThread."'";
                var_dump($sqlDelete);
                $result = mysqli_query($dbh, $sqlDelete);

                //getUserID
                $resultUserID = mysqli_query($dbh, "SELECT UserID FROM tblusers WHERE Username='".$username."'");
                $resultUser = mysqli_fetch_array($resultUserID);

                //OP viewed his post instantly
                $sqlInsertViewed = "INSERT INTO `honeypot`.`tblviewedthreads` (`ID`, `ThreadID`, `UserID`) VALUES (NULL, '".$currentThread."', '".htmlentities($resultUser['UserID'])."')";
                var_dump($viewed);
                $viewed = mysqli_query($dbh, $sqlInsertViewed);

            }

            //LASTPAGE
            $resultPages = mysqli_query($dbh, "SELECT COUNT(PostID) FROM tblMessages WHERE ThreadID='".$currentThread."'");
            $maxPage = mysqli_fetch_array($resultPages);

            if (($maxPage[0]/15) == 0) {
                $maxPageCeil = 1;
            } else {
                $maxPageCeil = ceil(($maxPage[0]/15));
            }

            $resultPostID = mysqli_query($dbh, "SELECT MAX(PostID) FROM tblMessages");
            $resPostID = mysqli_fetch_array($resultPostID);
            $dbh->close();

            header("Location: ../showthread.php?cat=".htmlentities($_SESSION['currentCat'])."&thread=".htmlentities($_SESSION['currentThread'])."&page=".$maxPageCeil."#".htmlentities($resPostID[0]));
        } else {
            header("Location: ../showthread.php?cat=".htmlentities($_SESSION['currentCat'])."&thread=".htmlentities($_SESSION['currentThread'])."&page=1");

        }

        function getUserID($username) {

            return $resultUser['UserID'];
        }
    } else {
        header("Location: ../showthread.php");

    }




}
?>