<?php
/**
 * Created by PhpStorm.
 * User: Giani
 * Date: 8/10/2014
 * Time: 20:53
 */

?>
<form id="frmLogin" action="./scriptfiles/srcLogin.php" method="POST" style="width: 500px; height: 41px">
    <table>
        <tr style="vertical-align: middle; line-height: 35px; color: white; font-weight: bold">
            <td><label for="inUsername">Username: </label></td>
            <td><input type="text" name="inUsername" placeholder="Enter a Username" /></td>
            <td><label for="inPassword">Password: </label></td>
            <td><input type="password" name="inPassword" placeholder="Enter Your Password"/></td>
            <td></td>
            <td><input id="btnRegister" type="submit" value="Login"></td>
        </tr>
    </table>
</form>
