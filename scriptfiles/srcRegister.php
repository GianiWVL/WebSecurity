<?php
/**
 * Created by PhpStorm.
 * User: Giani
 * Date: 8/10/2014
 * Time: 21:43
 */

if($_POST['inUsername'] && $_POST['inFirstName'] && $_POST['inLastName'] && $_POST['inEmail'] && $_POST['inConfirmEmail'] && $_POST['inPassword'] && $_POST['inConfirmPassword']){
    $inUsername = $_POST['inUsername'];
    $inFirstName = htmlentities($_POST['inFirstName']);
    $inLastName = htmlentities($_POST['inLastName']);

    $inEmail = htmlentities($_POST['inEmail']);
    $inConfirmEmail = htmlentities($_POST['inConfirmEmail']);

    $inPassword = htmlentities($_POST['inPassword']);
    $inConfirmPassword = htmlentities($_POST['inConfirmPassword']);

    $ip = $_SERVER['REMOTE_ADDR'];
}else{
    header('Location: '.$_SERVER['HTTP_REFERER']."?error=1");
    die();
}

if($inEmail != $inConfirmEmail){
    header('Location: ' .$_SERVER['HTTP_REFERER']."?error=2" );
    die();
}

if($inPassword != $inConfirmPassword){
    header('Location: ' .$_SERVER['HTTP_REFERER']."?error=3" );
    die();
}else{
    $inPassword = md5(md5($inPassword) + $inPassword);
}

//Kijken voor een geldig HowestEmail
//Kijken of Voornaam en Achternaam geregistreerd zijn bij Howest?? <--

include_once 'DBConnect.php';
if($dbh->connect_errno){
    echo "Failed to connect to database. Error: " . $dbh->connect_error;
    die();
}else{

    $inUsername = $dbh->real_escape_string($inUsername);
    $inFirstName = $dbh->real_escape_string($inFirstName);
    $inLastName = $dbh->real_escape_string($inLastName);
    $inEmail = $dbh->real_escape_string($inEmail);
    $inPassword = $dbh->real_escape_string($inPassword);
    $ip = $dbh->real_escape_string($ip);

    if($stmt = $dbh->prepare('SELECT * FROM tblusers WHERE UserName = ? OR Email = ?')){
        $stmt->bind_param('ss',$inUsername,$inEmail);
        $stmt->execute();
        $result = $stmt->get_result();


        if(mysqli_num_rows($result) <> 0){
            header('Location: ' .$_SERVER['HTTP_REFERER']."?error=4" );
            $result->close();
            die();
        }else{
            if($stmt = $dbh->prepare('INSERT INTO tblusers(UserName,FirstName,LastName,Email,Password,RegistratieIP) VALUES(?,?,?,?,?,?)')){
                $stmt->bind_param('ssssss', $inUsername,$inFirstName, $inLastName,$inEmail,$inPassword,$ip);
                $stmt->execute();
            }else{
                echo $dbh->error;
                die();
            }
        }

    }else{
        echo $dbh->error;
        die();
    }
    $dbh->close();
    header('Location: index.php' );
}


/*
echo $inUsername . '<br />' . $inFirstName . '<br />' . $inLastName . '<br />'
    . $inEmail . '<br />' . $inConfirmEmail . '<br />' . $inPassword . '<br />'
    . $inConfirmPassword . '<br />' . $ip;
echo var_dump($ip);
*/