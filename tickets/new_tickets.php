<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>New Tickets</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        error_reporting(E_ALL);
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        $result = $mysql->query("select * from venue;");
        $i = 0;
        while($row=$result->fetch_assoc()) {
            $venueID[$i] = $row['VenueID'];
            $venueName[$i] = $row['Name'];
            $i++;
        }
        $result->free();

        $result = $mysql->query("select * from distributor;");
        $i = 0;
        while($row=$result->fetch_assoc()) {
            $distributorID[$i] = $row['DistributorID'];
            $distributorName[$i] = $row['Company'];
            $i++;
        }
        $result->free();
        $i = 0;
        
        echo '<form name="ticket_info" method="post" enctype="multipart/form-data" action="ticket_submit.php">';
        echo '    <table border="0">';
        echo '        <tr><td>Title</td><td><input name="title" type="text"></td></tr>';
        echo '        <tr><td>Venue</td>';
        echo '            <td>';
        echo '                <select name="venue">';
                            for($i=0; $i<sizeof($venueID); $i++) {
        echo '                        echo <option value="' . $venueID[$i] . '">' . $venueName[$i] . '</option>';
                              }
        echo '                </select>';
        echo '            </td>';
        echo '        </tr>';
        echo '        <tr><td>Date</td><td><input type="date" name="date"></td></tr>';
        echo '        <tr><td>Time</td><td><input type="time" name="time"></td></tr>';
        echo '        <tr>';
        echo '            <td>Distributor</td>';
        echo '            <td>';
        echo '                <select name="distributor">';
                            for($i=0; $i<sizeof($distributorID); $i++) {
        echo '                        echo <option value="' . $distributorID[$i] . '">' . $distributorName[$i] . '</option>';
                              }   
        echo '                </select>';
        echo '            </td>';
        echo '        </tr>';
        echo '        <tr><td>Quantity</td><td><input type="text" name="quantity"></td></tr>';
        echo '        <tr><td>Reserve</td><td><input type="text" name="reserve"></td></tr>';
        echo '        <tr><td>Poster</td><td><input name="Poster" type="file" id="file"></td></tr>';
        echo '        <tr><td>Remarks</td><td><input type="text" name="remarks"></td></tr>';
        echo '        <tr><td colspan="2" align="right"><input type="submit" value="submit"><input type="button" value="Back" onClick="history.go(-1);return true;"></td></tr>';
        echo '    </table>';
        echo '</form>';
        ?>
    </body>
</html>
