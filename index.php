<?php

session_start();
if (isset($_SESSION['Logged']))
{
    header('location: loggedTest.php');
}

?>

<html>
    <head>
        <title></title>
        <style>
            body {
                margin-top: 50px;
                font-family: "Times New Roman", Georgia, Serif;
            }
            #frmLogin{
                /*width: 80%;*/
                margin: 0 auto;*/
            }

            #frmRegister{
                /*width: 80%;*/
                margin: 0 auto;*/
            }

            label, input{
                display: inline-block;
            }

            label{
                /*width: 20%;*/
                width: 130px;
                text-align: right;
            }

            label + input{
                width: 250px;
                margin: 0 0 0 5px;
            }

            #btnRegister{
                width: 100%;

            }

            #tblRegLog td{
                vertical-align: text-top;
            }

            #tblRegLog{
                margin: auto;
            }

            a {
                text-align: center;
            }

            #menu {
                margin-left: 0%;
                top: 0px;
                left: 0px;
                position: fixed;
                width: 100%;
                height: 41px;
                padding-left: 10%;
                background-color: red;
                margin-left: auto;
                margin-right: 5%;
                display: inline-block;
            }

            #menu a {
                color: white;
                font-weight: bold;
                display: inline-block;
                height: 35px;
                width: 60px;
                padding-left: 20px;
                padding-right: 20px;
                padding-top: 10px;
                padding-bottom: 10px;
                text-decoration: none;
                float: left;
            }

        </style>
    </head>
    <body>
        <table id="tblRegLog">
            <thead>
                <tr>
                    <th>Register</th>
                </tr>
            </thead>
            <tr>
                <td>
                    <?php
                        include_once 'formRegister.php';
                    ?>
                </td>
                <td>
                </td>
            </tr>
        </table>


        <nav id="menu">
            <a href="index.php">Registreer|Login</a>
            <div id="login" style="vertical-align: middle;line-height: 50px;">
                <?php
					include_once 'formLogin.php';
                ?>
            </div>
        </nav>
    </body>
</html>