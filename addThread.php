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

        td  {
            vertical-align: top;
        }

        a {
            text-align: center;
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
    </style>
</head>
<body>
<div id="fullBody">
    <nav id="menu">
        <a href="categorie.php">Forum</a><br>
        <a href="index.php" id="login"><?php include_once "loginCheck.php"; if($_SESSION['Logged'] != ''){ echo 'Logout'; } else { echo 'Registreer|Login'; } ?></a>
    </nav>
    <div id="newMessage">
    <h2>New thread:</h2>

    <form method="post" action="srcNewThread.php">
        <table>
            <tr>
                <td style='width: 100px'>Thread title:</td>
                <td colspan="2">
                    <input type="text" name="txtThreadTitle" id="txtThreadTitle" style="width: 500px"></textarea>
                </td>
            </tr>
            <tr>
                <td style='width: 100px'>Message:</td>
                <td colspan="2">
                    <textarea id="txtMessage" name="txtSendMessage" style="width: 500px; height: 100px;"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Captcha:
                </td>
                <td style="width: 100px">
                    <?php
                    $getal1;
                    $getal2;

                    $getal1 = rand(0, 10);
                    $getal2 = rand(10, 20);

                    echo $getal1." + ".$getal2." =";
                    $_SESSION['captchaResult'] = $getal1 + $getal2;
                    $_SESSION['currentCat'] = $_GET['cat'];
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