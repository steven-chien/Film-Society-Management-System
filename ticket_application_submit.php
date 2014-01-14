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
        date_default_timezone_set("Asia/Hong_Kong");
        // put your code here
        #debug
        if($_POST['review']=='ready') {
            
            echo $_POST['review'].'<br>';
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            if(!$mysql) {
                echo mysqli_connect_error();
            }
            for($i=0; $i<sizeof($_POST['Timestamp']); $i++) {
                if($_POST['Confirmation'][$i]=='1') {
                    $Quantity = 2;
                }
                else {
                    $Quantity = 0;
                }
                $query = sprintf("insert into tickets_application(StudentID, Timestamp, Answer, Response, Confirmation, TicketID, Quantity) values('%s', '%s', '%s', %d, %d, %d, %d);", $_POST['StudentID'][$i], $_POST['Timestamp'][$i], $_POST['Answer'][$i], $_POST['Response'][$i], $_POST['Confirmation'][$i], $_POST['TicketID'], $Quantity);
                $result = $mysql->query($query);
                if(!$result) {
                    echo mysqli_error($mysql);
                    echo $_POST['StudentID'][$i] . ' not imported. <br>';
                }
            }
            $redirect = "location:tickets_application.php?TicketID=".filter_input(INPUT_POST, 'TicketID');
            $_POST['review'] = NULL;
            header($redirect);
        }
        else {
            echo 'not ready<br>';
            $file = fopen($_FILES['CSV']['tmp_name'], 'r');
            $header = NULL;
        }
        echo "Upload: " . $_FILES["CSV"]["name"] . "<br>";
        ?>
        <form name="application_submit" method="post" action="ticket_application_submit.php">
            <table cellpadding="10">
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
                            echo '<td>'.$timestamp.'<input type="hidden" name="Timestamp[]" value="'.$timestamp.'"></td>';
                            echo '<td><input type="text" name="StudentID[]" value="'.$row[1].'"></td>';
                            echo '<td><input type="text" name="Answer[]" value="'.$row[5].'"></td>';
                            echo '<td align="right"><select name="Response[]">';if($row[6]=='1') { echo '<option value="1" selected="selected">Yes</option><option value="0">No</option>'; } else { echo '<option value="1">Yes</option><option value="0" selected="selected">No</option>'; } echo '</select></td>';
                            echo '<td align="right"><select name="Confirmation[]">';if($row[7]=='1') { echo '<option value="1" selected="selected">Yes</option><option value="0">No</option>'; } else { echo '<option value="1">Yes</option><option value="0" selected="selected">No</option>'; } echo '</select></td>';
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
            <input type="hidden" name="TicketID" value="<?php echo $_POST['TicketID']; ?>">
        </form>
    </body>
</html>