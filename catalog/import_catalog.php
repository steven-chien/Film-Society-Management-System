<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Import catalog</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        ?>
        <form name="catalog" method="post" enctype="multipart/form-data" action="catalog_submit.php">
            <table>
                <tr>
                    <td>CSV File</td><td align="right"><input name="file" type="file" id="file"></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td align="right">
                        <select name="Media">
                            <option value="0">VHS</option>
                            <option value="1">VCD</option>
                            <option value="2">DVD</option>
                        </select>
                    </td>
                    
                </tr>
                <tr>
                    <td>ID Column</td><td align="right"><input name="ID_col" type="text" value="0"></td>
                </tr>
                <tr>
                    <td>Title Column</td><td align="right"><input name="Title_col" type="text" value="1"></td>
                </tr>
                <tr>
                    <td>Qty Column</td><td align="right"><input name="Qty_col" type="text" value="2"></td>
                </tr>
                <tr>
                    <td>Year Column</td><td align="right"><input name="Year_col" type="text" value="6"></td>
                </tr>
                <tr><td colspan="2" align="right"><input type="submit" name="submit" value="submit"><input type="button" value="Back" onClick="history.go(-1);return true;"></td></tr>
            </table>
        </form>
    </body>
</html>
