<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <p>Film Society Management System</p>
        <form name="login" method="post" action="login.php">
            <table border="0">
                <tr><td>User</td><td><input name="user" type="text"></td></tr>
                <tr><td>Password</td><td><input name="password" type="password"></td></tr>
            </table>
            <input type="submit" name="submit" value="submit">
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
