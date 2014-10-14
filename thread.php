<!DOCTYPE html>
<html>
<head>
    <title>FORUM - Honeypot</title>
    <style>
        body {
            width: 100%;
            font-family: "Times New Roman", Georgia, Serif;
            position: relative;
            top: 50px;
        }

        #fullBody {
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        #historyMessages {
            width: 100%;
            height: auto;
        }

        td  {
            vertical-align: top;
        }

        a {
            text-align: center;
            text-decoration: none;
            color: red;

        }

        a:hover {
            color: grey;
        }

        #pHeader {
            width: 45%;
            color: red;
            margin-top: 30px;
            font-size: 40px;
            font-weight: bold;
            display: block;
        }
        
        #header {
            display: block;
        }

        #menu {
            background-color: red;
            margin-left: 0px;
            left: 0px;
            top:0px;
            position: fixed;
            width: 100px;
            height: 100%;
        }

        #menu a {
            color: white;
            display: inline-block;
            height: 35px;
            width: 60px;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 20px;
            padding-bottom: 20px;
            text-decoration: none;
        }

        .userlink {
            color: red;
            text-decoration: none;
        }

        img {
            width: 150px;
            height: 150px;
            margin: auto;
            text-align: center;
        }

        #divPages {
            width: 100%;
            text-align: right;
        }

        .fontPagesNormal {
            text-decoration: none;
            color: black;
            text-align: right;
        }

        .fontPagesCurrent {
            text-decoration: none;
            color: red;
            text-align: right;
        }

        tr, td {
            color: black;
            border-bottom: 1px solid;
        }

        table {
            width: 100%;
        }

        .threadTitle {
            width: 40%;
            height: 55px;
            vertical-align: middle;
            text-align: left;
        }

        .threadDateTime {
            width: 15%;
            height: 50px;
            vertical-align: middle;
            text-align: center;
            border-left: 1px solid;
        }

        .threadUsername {
            width: 20%;
            height: 50px;
            vertical-align: middle;
            text-align: center;
            border-left: 1px solid;
        }

        .threadHover:hover {
            background-color: whitesmoke;
            color: gray;
        }

        .threadHover:hover a {
            background-color: whitesmoke;
            color: gray;
        }

        th {
            border-bottom: 1px solid;
        }

        #newThread {
            color: white;
            font-weight: bold;
            width: 15%;
            height: 50px;
            background-color: red;
            text-align: center;
            vertical-align: middle;
            line-height: 50px;
            display: block;
            margin-left: auto;
            margin-right: 0px;
            margin-top: 30px;
            border: 1px solid;
        }

        #newThread:hover {
            background-color: white;
            color: red;
            border: 1px solid;
        }

        .unread {
            font-weight: bolder;
            font-size: 20px;
        }
    </style>
</head>
<body>
<div id="fullBody">
    <nav id="menu">
        <a href="categorie.php">Forum</a><br>
        <a href="index.php" id="login"><?php include_once "loginCheck.php"; if($_SESSION['Logged'] != ''){ echo 'Logout'; } else { echo 'Registreer|Login'; } ?></a>
    </nav>
    <div  id="header">
        <div id="pHeader">
            <?php
            include_once 'scriptfiles/DBConnect.php';
            global $dbh;
            $cat = htmlentities($_GET['cat']);
            $resultThreads = mysqli_query($dbh, "SELECT Title FROM tblCategorie WHERE CategorieID='".htmlentities($cat)."'");
            $result = mysqli_fetch_array($resultThreads);
            echo "<a href=categorie.php?cat=".$cat.">".$result['Title']."</a>";
            ?>
            </div>
        <?php
        echo "<a href='addThread.php?cat=";
        echo htmlentities($_GET['cat'])."'>";
        $_SESSION['currentCat'] = $_GET['cat'];
        ?>

            <div id="newThread">New Thread</div></a>
    </div>

    <div id='divMain'>
        <div id='history'>
            <div id='historyMessages' >
                <?php
                include_once 'scriptfiles/DBConnect.php';

                if (isset($_GET['cat'])) {
                    $cat = $_GET['cat'];
                    if ($dbh->connect_errno) {
                        echo "Failed to connect to database. Error: " . $dbh->connect_error;
                        die();
                    } else {
                        global $cat;
                        loadThreads($cat);
                        $dbh->close();
                    }
                } else {
                    header("Location: categorie.php");
                }

                function loadThreads($categorie) {
                    global $dbh;

                    $resultThreads = mysqli_query($dbh, "SELECT * FROM tblThreads WHERE CategorieID='".$categorie."' ORDER BY LastEdited DESC");

                    $sql = "SELECT DISTINCT ThreadID as TID FROM tblviewedthreads WHERE UserID='".htmlentities(getUserID($_SESSION['Logged']))."'";

                    $resultViews = mysqli_query($dbh, $sql);


                    echo "<table class='threadTable'>";
                    echo "<tr class='threadTableHeader'>";
                    echo "<th>";
                    echo "Title";
                    echo "</th>";
                    echo "<th>";
                    echo "Created";
                    echo "</th>";
                    echo "<th>";
                    echo "Last Edited";
                    echo "</th>";
                    echo "</tr>";

                    $views = array();
                    $i = 0;
                    while ($resViews = mysqli_fetch_array($resultViews)) {
                        $views[$i] = $resViews[0];
                        $i++;
                    }

                    $i = 0;
                    $done = false;
                    $placed = false;
                    $viewed = false;
                    while ($resultThread = mysqli_fetch_array($resultThreads)) {
                        $resultTotalPosts = mysqli_query($dbh, "SELECT COUNT(PostID) FROM tblmessages WHERE ThreadID='".$resultThread['ThreadID']."'");
                        $resultTotalPost = mysqli_fetch_array($resultTotalPosts);
                        global $viewed;
                        echo "<tr class='threadHover'>";
                        echo "<td class='threadTitle'>";
                        while (count($views) > $i && $done == false && $placed == false)
                        {
                            if ($views[$i] == $resultThread['ThreadID'])
                            {
                                $viewed = true;
                                if ($viewed) {
                                    echo "<a href='showthread.php?cat=".$categorie."&thread=".$resultThread['ThreadID']."'>[GELEZEN] - ".$resultThread['Title']."</a><br>";
                                    echo "Total posts: ".$resultTotalPost[0];
                                    $done = true;
                                    $placed = true;
                                } else {
                                    if ($placed == false && $done == false) {
                                        echo "<a class='unread' href='showthread.php?cat=".$categorie."&thread=".$resultThread['ThreadID']."'>[NIEUW] - ".$resultThread['Title']."</a><br>";
                                        echo "Total posts: ".$resultTotalPost[0];
                                        $placed = true;
                                        $done = true;
                                    }
                                }
                            }
                            $i++;
                        }
                        if ($placed == false && $done == false) {
                            echo "<a class='unread' href='showthread.php?cat=".$categorie."&thread=".$resultThread['ThreadID']."'>[NIEUW] - ".$resultThread['Title']."</a><br>";
                            echo "Total posts: ".$resultTotalPost[0];
                            $placed = true;
                            $done = true;

                        }
                        echo "</td>";
                        echo "<td  class='threadUsername'>";
                        echo "<a href='profiel.php?Username=".getUsername($resultThread['UserID'])."'>".getUsername($resultThread['UserID'])."</a><br>";
                        echo $resultThread['DateTime'];
                        echo "</td>";
                        echo "<td  class='threadDateTime'>";
                        echo "<a href='profiel.php?Username=".getUsername($resultThread['LastEditedUserID'])."'>".getUsername($resultThread['LastEditedUserID'])."</a><br>";
                        echo $resultThread['LastEdited'];
                        echo "</td>";
                        echo "</tr>";
                        $done = false;
                        $placed = false;
                        $viewed = false;
                        $i = 0;
                    }
                    echo "</table>";
                }

                function getUsername($id) {
                    global $dbh;
                    $resultUsername = mysqli_query($dbh, "SELECT UserName FROM tblusers WHERE UserID='".$id."'");
                    $resultUsername = mysqli_fetch_array($resultUsername);
                    return $resultUsername['UserName'];
                }


                function getUserID($username) {
                    global $dbh;
                    $resultUserID = mysqli_query($dbh, "SELECT UserID FROM tblusers WHERE Username='".$username."'");
                    $resultUser = mysqli_fetch_array($resultUserID);
                    return $resultUser['UserID'];
                }


                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>