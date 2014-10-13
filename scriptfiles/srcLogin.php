<?php
/**
 * Created by PhpStorm.
 * User: Giani
 * Date: 9/10/2014
 * Time: 19:13
 */

if($_POST['inUsername'] && $_POST['inPassword']){
    $inUsername = htmlentities($_POST['inUsername']);
    $inPassword = htmlentities($_POST['inPassword']);
}else{
    header('Location: '.$_SERVER['HTTP_REFERER']."?error=5");
    die();
}

include_once 'DBConnect.php';
if($dbh->connect_error){

}else{

    $inUsername = $dbh->real_escape_string($inUsername);
    $inPassword = $dbh->real_escape_string($inPassword);
    $inPassword = md5(md5($inPassword) + $inPassword);

    if($stmt = $dbh->prepare('SELECT * FROM tblusers WHERE UserName = ? AND Password = ?')){
        $stmt->bind_param('ss',$inUsername,$inPassword);

        $stmt->execute();
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) == 1){
            while($row = $result->fetch_assoc()) {
                session_start();
                $_SESSION['Logged'] = $row['UserName'];
                header('Location: categorie.php' );
            }
            $result->close();
        }else{
            header('Location: ' .$_SERVER['HTTP_REFERER']."?error=6" );
            $result->close();
            die();
        }
    }else{
        echo $dbh->error;
        die();
    }
    $dbh->close();
    //header('Location: loggedTest.php' );
}


//echo $inUsername . '<br />' . $inPassword;