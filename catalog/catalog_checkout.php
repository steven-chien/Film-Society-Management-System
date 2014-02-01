<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        if(isset($_POST['StudentID'])&&($_POST['StudentID']!='')) {
            echo '<form name="catalog_checkout_submit" action="catalog_checkout_submit.php" method="post">';
            echo '<table>';
            echo '<tr><td>1</td><td><input type="text" name="MovieID_1"></td></tr>';
            echo '<tr><td>2</td><td><input type="text" name="MovieID_2"></td></tr>';
            echo '<tr><td>3</td><td><input type="text" name="MovieID_3"></td></tr>';
            echo '<tr><td align="right" colspan="2"><input type="submit" name="submit" value="submit"></td><tr>';
            echo '</table>';
            echo '<input type="hidden" name="StudentID" value="'.filter_input(INPUT_POST, 'StudentID').'">';
            echo '</form>';
        }
        else {
            echo '<form name="catalog_checkout" action="catalog_checkout.php" method="post">';
            echo '    <table>';
            echo '        <tr><td>StudentID</td><td><input type="text" name="StudentID"></td></tr>';
            echo '        <tr><td colspan="2" align="right"><input type="submit" name="submit" value="submit"></td></tr>';
            echo '    </table>';
            echo '</form>';
        }
        echo '<p><a href="../home.php">Go Back</a></p>';
        ?>
    </body>
</html>