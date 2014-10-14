<?php
session_start();
if (!isset($_SESSION['Logged']))
{
    header('location: index.php');
}
?>