<?php
/**
Door Tommy
 */
include_once 'DBConnect.php';

if($dbh->connect_error){

    echo 'fout';
    die();
    exit();

}
session_start();
$inUsername = $_SESSION['Logged'];

function terugKeren($name){
    echo '<a href="profiel.php?Username='.htmlentities($name).'">Klik hier om terug te keren.</a>';
}

if($_POST['inOldPassword'] && $_POST['inNewPassword'] && $_POST['inNewPasswordCheck']){

    $getOldPassword = mysqli_query($dbh, "SELECT Password FROM tblusers WHERE UserName ='".htmlentities($inUsername)."'");

    $OldPassword = mysqli_fetch_array($getOldPassword);
    $oldPasswordExtractedFromArray = $OldPassword[0];
    $inNewPasswordEncrypted = htmlentities($_POST['inNewPassword']);
    $inNewPasswordCheck = htmlentities($_POST['inNewPasswordCheck']);
    $inOldPassword = htmlentities($_POST['inOldPassword']);
    $inOldPasswordEncrypted = $inOldPassword;
    $inOldPasswordEncrypted = md5(md5($inOldPasswordEncrypted) + $inOldPasswordEncrypted);

    if (strcmp($inNewPasswordEncrypted, $inNewPasswordCheck) !== 0){
        echo '<p>De wachtwoorden komen niet overeen. Gelieve opnieuw te proberen.</p>';
       terugKeren($inUsername);
        die();
        exit();
    }
    if(strcmp($inOldPasswordEncrypted,$oldPasswordExtractedFromArray) !== 0){

        echo 'Verkeerd wachtwoord ingevoerd!';
        terugKeren($inUsername);
        exit();
        die();
    }

    if($stmt = $dbh->prepare("UPDATE tblusers SET Password=? WHERE UserName = ? ")){
        $inNewPasswordEncrypted = md5(md5($inNewPasswordEncrypted) + $inNewPasswordEncrypted);
        $stmt->bind_param('ss',$inNewPasswordEncrypted,$inUsername);
        $stmt->execute();
        echo 'Gelukt! Uw wachtwoord is veranderd.';
        terugKeren($inUsername);
    }

}else{
header('Location: '.$_SERVER['HTTP_REFERER']."?error=5");
die();
}







?>