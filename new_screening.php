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
        <?php session_start(); if($_SESSION['login']!='1') { header("location:index.php");}?>
        <?php
        // put your code here
        ?>
        <form name="screening" method="post" enctype="multipart/form-data" action="screening_submit.php">
            <table>
                <tr>
                    <td>Date</td><td align="right"><input type="date" name="Date"></td>
                </tr>
                <tr>
                    <td>Time</td><td align="right"><input type="time" name="Time"></td>
                </tr>
                <tr>
                    <td>Title</td><td align="right"><input type="text" name="Title"></td>
                </tr>
                <tr>
                    <td>Venue</td><td align="right"><input type="text" name="Venue"></td>
                </tr>
                <tr>
                    <td>Expense</td><td align="right"><input type="text" name="Expense"></td>
                </tr>
                <tr><td>Poster</td><td><input name="Poster" type="file" id="file"></td></tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" name="submit" value="submit"><input type="button" value="Back" onClick="history.go(-1);return true;"></td>
                </tr>
            </table>
        </form>
    </body>
</html>
