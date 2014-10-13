<?php
/**
 * Created by PhpStorm.
 * User: Giani
 * Date: 8/10/2014
 * Time: 20:53
 */

?>

<form id="frmRegister" action="srcRegister.php" method="POST">
    <table>
        <tr>
            <td><label for="inUsername">Username: </label></td>
            <td><input type="text" name="inUsername" placeholder="Enter a Username" /></td>
            <td>*</td>
        </tr>
        <tr>
            <td><label for="inFirstName">First Name: </label></td>
            <td><input type="text" name="inFirstName" placeholder="Enter Your First Name" /></td>
            <td>*</td>
        </tr>
        <tr>
            <td><label for="inLastName">Last Name: </label></td>
            <td><input type="text" name="inLastName" placeholder="Enter Your Last Name" /></td>
            <td>*</td>
        </tr>
        <tr>
            <td><label for="inEmail">Email: </label></td>
            <td><input type="text" name="inEmail" placeholder="Enter Your Howest Email" /></td>
            <td>*</td>
        </tr>
        <tr>
            <td><label for="inConfirmEmail">Confirm Email: </label></td>
            <td><input type="text" name="inConfirmEmail" placeholder="Confirm Your Email" /></td>
            <td>*</td>
        </tr>
        <tr>
            <td><label for="inPassword">Password: </label></td>
            <td><input type="password" name="inPassword" placeholder="Enter Your Password"/></td>
            <td>*</td>
        </tr>
        <tr>
            <td><label for="inConfirmPassword">Confirm Password: </label></td>
            <td><input type="password" name="inConfirmPassword" placeholder="Confirm You Password"/></td>
            <td>*</td>
        </tr>
        <tr>
            <td></td>
            <td><input id="btnRegister" type="submit" value="Register"></td>
        </tr>
    </table>
</form>
