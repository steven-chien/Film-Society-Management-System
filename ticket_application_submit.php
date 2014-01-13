<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Application Info</title>
    </head>
    <body>
        <?php session_start(); if($_SESSION['login']!='1') { header("location:index.php"); } ?>
        <?php
        // put your code here
        $file = fopen($_FILES['CSV']['tmp_name'], 'r');
        $header = NULL;
        #debug
        if($_POST['review']=='ready') {
            echo $_POST['review'].'<br>';
            for($i=0; $i<sizeof($_POST['Timestamp']); $i++) {
                echo $_POST['Timestamp'][$i];
                echo '<br>';
            }
        }
        else {
            echo 'not ready<br>';
        }
        echo "Upload: " . $_FILES["CSV"]["name"] . "<br>";
        ?>
        <form name="application_submit" method="post" action="ticket_application_submit.php">
            <table>
                <tr>
                    <td>Timestamp</td>
                    <td>StudentID</td>
                    <td>Answer</td>
                    <td>Response</td>
                    <td>Confirmation</td>
                </tr>
                    <?php
                    while($row=fgetcsv($file, 1000, ',')) {
                        if(!$header) {
                            $header = $row;
                        }
                        else {
                            echo '<tr>';
                            $timestamp = DateTime::createFromFormat('m/d/Y H:i:s',$row[0])->format('Y-m-d H:i:s');
                            echo '<td><input type="text" name="Timestamp[]" value="'.$timestamp.'"></td>';
                            echo '<td><input type="text" name="StudentID[]" value="'.$row[1].'"></td>';
                            echo '<td><input type="text" name="Answer[]" value="'.$row[5].'"></td>';
                            echo '<td align="right"><select name="Response[]">';if($row[6]=='1') { echo '<option value="1" selected="selected">Yes</option><option value="0">No</option>'; } else { echo '<option value="1">Yes</option><option value="0" selected="selected">No</option>'; } echo '</select></td>';
                            echo '<td align="right"><select name="Confimration[]">';if($row[7]=='1') { echo '<option value="1" selected="selected">Yes</option><option value="0">No</option>'; } else { echo '<option value="1">Yes</option><option value="0" selected="selected">No</option>'; } echo '</select></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                <tr>
                    <td colspan="4" align="right">Are you sure the above information is correct?</td>
                    <td align="right">
                        <input type="submit" name="submit" value="yes">
                        <input type="button" value="Back" onClick="history.go(-1);return true;">
                    </td>
                </tr>
            </table>
            <input type="hidden" name="review" value="ready">
        </form>
    </body>
</html>
