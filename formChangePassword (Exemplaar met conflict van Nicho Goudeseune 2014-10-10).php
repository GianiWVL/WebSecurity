<a href="#"><h2>Edit password</h2></a>
<form id="frmChangePassword" action="srcChangePassword.php" method="POST">
    <table>
        <tr>
            <td><label for="inOldPassword">Old Password: </label><br>
                <input type="password" name="inOldPassword"/></td>
            <td>*</td>
        </tr>
	<tr>
            <td><label for="inNewPassword">New password: </label><br>
                <input type="password" name="inNewPassword"/></td>
            <td>*</td>
        </tr>
	<tr>
            <td><label for="inNewPasswordCheck">Retype new password</label><br>
                <input type="password" name="inNewPasswordCheck"/></td>
            <td>*</td>
        </tr>
        <tr>
            <td><input id="btnChangePw" type="submit" value="changePw"></td>
        </tr>
    </table>
</form>