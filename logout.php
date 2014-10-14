<?php
/**
 * Created by PhpStorm.
 * User: Giani
 * Date: 9/10/2014
 * Time: 20:11
 */

session_start();

$_SESSION = array();

session_destroy();

header('location: index.php')
?>