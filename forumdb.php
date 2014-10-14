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
        }

        #header {
            color: red;
            margin-top: 30px;
        }

        #menu {
            background-color: red;
            margin-left: 5%;
            left: 0px;
            top:0px;
            position: fixed;
            width: 100px;
            height: 100%;
            background-color: red;
            margin-left: 0px;
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
    </style>
</head>
<body>
    <div id="fullBody">
        <nav id="menu">
            <a href="categorie.php">Categorie</a><br>
            <a href="forumdb.php">Forum</a><br>
            <a href="index.php" id="login"><?php include_once "loginCheck.php"; if($_SESSION['Logged'] != ''){ echo 'Logout'; } else { echo 'Registreer|Login'; } ?></a>
        </nav>
        <div id="header">
            <h1>[[THREAD TITLE]]</h1>
        </div>

        <div id='divMain'>
            <div id='history'>
                <div id='historyMessages' >
                    <?php
                    if (isset($_GET['page'])) {
                        $currentpage;
                        include_once "DBConnect.php";
                        include_once "loginCheck.php";

                        if ($dbh->connect_errno) {
                            echo "Failed to connect to database. Error: " . $dbh->connect_error;
                            die();
                        } else {

                            global $currentpage;
                            if (isset($_GET['page'])) {
                                global $currentpage;
                                $currentpage = $_GET['page'];
                            }
                            $resultMessages;

                            //LASTPAGE
                            $resultPages = mysqli_query($dbh, "SELECT COUNT(PostID) FROM tblMessages");
                            $maxPage = mysqli_fetch_array($resultPages);
                            $maxPageCeil = ceil(($maxPage[0] / 15));

                            getPages($currentpage);
                            echo '<hr>';

                            if ($currentpage <= $maxPageCeil && $currentpage > 0)
                            {
                                global $currentpage;
                                if ($currentpage == '' || $currentpage == NULL) {
                                    global $resultMessages;
                                    $resultMessages = "";
                                } else {
                                    global $resultMessages;
                                    global $currentpage;
                                    $resultMessages = mysqli_query($dbh, "SELECT * FROM tblMessages WHERE PostID BETWEEN '" . ((($currentpage - 1) * 15) + 1) . "' AND '" . (($currentpage) * 15) . "'");;
                                }

                                while ($row = mysqli_fetch_array($resultMessages)) {
                                    $resultUserName = mysqli_query($dbh, "SELECT tblUsers.UserName FROM `tblMessages` JOIN tblUsers on tblUsers.UserID = tblMessages.UserID WHERE tblUsers.UserID = " . $row['UserID']);
                                    $rowUser = mysqli_fetch_array($resultUserName);
                                    echo "<table class='tblHistoryMessages' id=" . $row['PostID'] . ">";
                                    echo "<tr>";
                                    echo "<td style='width: 17%'>";
                                    //FOTO HIER
                                    echo "<a href='profiel.php?Username=" . $rowUser['UserName'] . "' class='userlink'><img src='https://forums.oneplus.net/styles/oneplus2014/xenforo/avatars/avatar_l.png' /></a>";
                                    echo "<p style='color: red'><a href='profiel.php?Username=" . $rowUser['UserName'] . "' class='userlink'>" . $rowUser['UserName'] . "</a></p>";
                                    echo $row['DateTime'];
                                    echo "</td>";
                                    echo "<td style='word-break: break-all; width: 85%; height: auto; margin-left: auto; margin-right: auto; padding-left: 25px; border-left: 1px solid' rowspan='2'>";
                                    echo nl2br($row['Body']);
                                    echo "</td>";
                                    echo "<td style='width: 5%'><a href='#" . intval($row['PostID']) . "'>" . $row['PostID'] . "</a></td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "</td>";
                                    echo "</tr>";
                                    echo "</table>";
                                    echo "<br><hr>";
                                }

                                getPages($currentpage);
                                $dbh->close();
                            } else {
                                header("Location: forumdb.php?page=1");
                            }
                        }
                    } else {
                        header("Location: forumdb.php?page=1");
                    }


                    function getPages($currentpagevar) {
                        global $dbh;
                        $resultMessages = mysqli_query($dbh, "SELECT COUNT(PostID) FROM tblMessages");
                        $row = mysqli_fetch_array($resultMessages);

                        echo "<div id='divPages'>Page:";
                        for ($i = 1; $i < ($row[0] / 15) + 1; $i++) {
                            if ($i == $currentpagevar){
                                echo "<a href='?page=" . $i . "' class='fontPagesCurrent'> [" . $i . "] </a>";
                            } else {
                                echo "<a href='?page=" . $i . "' class='fontPagesNormal'> [" . $i . "] </a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
            <div id="newMessage">
                <h2>New message:</h2>

                <form method="post" action="srcPostMessage.php">
                    <table>
                        <tr>
                            <td style='width: 100px'>Message:</td>
                            <td colspan="2">
                                <textarea id="txtMessage" name="txtSendMessage" rows="4" cols="40"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Captcha:
                            </td>
                            <td>
                                <?php
                                $getal1;
                                $getal2;

                                $getal1 = rand(0, 10);
                                $getal2 = rand(10, 20);

                                echo $getal1." + ".$getal2." =";
                                $_SESSION['captchaResult'] = $getal1 + $getal2;
                                ?>
                            </td>
                            <td>
                                <input type="text" name="captcha" id="captcha">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button id="sendMessage" name="sendMessage" type="submit">Send</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>