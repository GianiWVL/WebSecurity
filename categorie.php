<!DOCTYPE html>
<html>
<head>
    <title>Categorie - Honeypot</title>
    
    <style>
        body {
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
            margin-top: 50px;
            font-family: "Times New Roman", Georgia, Serif;
        }

        .catStyle {
            padding: 15px;
        }

        a {
            text-align: center;
            text-decoration: none;
            color: red;
            
        }
        
        a:hover {
            color: grey;
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
    </style>
</head>
<body>


    <nav id="menu">
        <a href="categorie.php">Forum</a>
        <a href="index.php"><?php include_once "loginCheck.php"; if($_SESSION['Logged'] != ''){ echo 'Logout'; } else { echo 'Registreer|Login'; } ?></a>
    </nav>
    <?php
    include_once "DBConnect.php";
    if($dbh->connect_errno){
        echo "Failed to connect to database. Error: " . $dbh->connect_error;
        die();
    }else{
        RedirectCategorie();

        $result = mysqli_query($dbh,"SELECT * FROM tblCategorie");

        while( $row = mysqli_fetch_array($result)) {
            $catID = str_replace(" ", "", $row['CategorieID']);
            echo "<div class='catStyle'>";
            echo "<h2><a class='catStyle' href='?cat=".$catID."'>".$row['Title']."</a></h2>";
            echo "</div>";
            echo "<hr><br>";
        }

        $dbh->close();
    }


    function RedirectCategorie() {
        global $dbh;
        if (isset($_GET['cat'])) {
            $cat = $_GET['cat'];
            var_dump($_GET);

            $result = mysqli_query($dbh,"SELECT CategorieID FROM tblCategorie WHERE CategorieID='".$cat."'");
            $row = mysqli_fetch_array($result);
            header("Location: thread.php?cat=".$row[0]);

        }
    }
    ?>
</body>
</html>