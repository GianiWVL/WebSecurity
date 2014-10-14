<html lang="nl" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Profiel</title>
    <style>
        body {
            width: 100%;
            font-family: "Times New Roman", Georgia, Serif;
        }

        #fullBody {
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
        }

        #colRight {
            width: 45%;
        }

        #colLeft {
            width: 45%;
			float: left;
        }
		
		footer {
			text-align: center;
			clear: left;
		}

        nav a {
            text-align: center;
        }

        a {
            text-align: left;
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: grey;
        }

        #menu {
            margin-left: 0%;
            top: 0px;
            left: 0px;
            position: absolute;
            width: 100%;
            height: 41px;
            padding-left: 10%;
            background-color: red;
            margin-left: auto;
            margin-right: 5%;
        }

        #menu a {
            color: white;
            display: inline-block;
            height: 35px;
            width: 60px;
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        
        img {
            width: 150px;
            height: 150px;
            margin: auto;
            text-align: center;
        }
        
        #colLeft{
            float:left;
            width: 170px;
        }
        
        #colRight{
            margin-left: 170px;
            width: auto;
        }
    </style>
</head>
<body>
    <div id="navigationBar">
        <nav id="menu">
            <a href="categorie.php">Forum</a>
            <a href="index.php" id="login"><?php include_once "loginCheck.php"; if($_SESSION['Logged'] != ''){ echo 'Logout'; } else { echo 'Registreer|Login'; } ?></a>
        </nav>
    </div>
    <div id="fullBody">
        <div id="content">
            <h1>Profile</h1>
            <div id="colLeft">
                <?php 
                    include_once 'srcGetProfile.php';
                    include_once 'srcGetPicture.php';
                ?>
            </div>
            
            <div id="colRight">
                <?php 
                    include_once 'srcGetProfile.php';
                    echo "<h2>Username: " . $data['UserName'] . "</h2>";
                    echo "<h2>First name: " . $data['FirstName'] . "</h2>";
                    echo "<h2>Last Name: " . $data['LastName'] . "</h2>";
                    //Show edit                
                    if($_SESSION['Logged'] == $_GET['Username']){
                    include_once 'formUploadPicture.php';
                    include_once 'formChangePassword.php';}
                ?>
            </div>
        </div>
    </div>
    <footer>Tommy - Giani - Jonas - Nicho</footer>
</body>
</html>