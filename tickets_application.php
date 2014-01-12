<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tickets Record</title>
    </head>
    <body>
        <?php session_start(); if($_SESSION['login']!='1') { header("location:index.php");}?>
        <?php
        // put your code here
        if(isset($_GET['TicketID'])) {
            $query = sprintf("select TA.StudentID, M.Name, M.Surname, if(TA.Response=1, 'Yes', 'No') as Response, if(TA.Confirmation=1, 'Yes', 'No') as Confirmation from tickets_application as TA left outer join member as M on M.StudentID=TA.StudentID where TA.TicketID=%d ", filter_input(INPUT_GET, 'TicketID'));
            
            if(isset($_GET['Response'])&&filter_input(INPUT_GET, 'Response')=='Yes') {
                $query = $query . ' and Response=1';
            }
            else if(isset($_GET['Response'])&&filter_input(INPUT_GET, 'Response')=='No') {
                $query = $query . ' and Response=0';
            }
            if(isset($_GET['Confirmation'])&&filter_input(INPUT_GET, 'Confirmation')=='Yes') {
                $query = $query . ' and Confirmation=1';
            }
            else if(isset($_GET['Confirmation'])&&filter_input(INPUT_GET, 'Confirmation')=='No') {
                $query = $query . ' and Confirmation=0';
            }
            $query = $query . ' order by Response desc, Confirmation desc;';
#echo $query;
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            if(!$mysql) {
                die(mysqli_connect_error());
            }

            $result = $mysql->query($query);
            if(!$result) {
                die(mysqli_errno());
            }
            
            echo '<table>';
            echo '<tr><td>StudentID</td><td>Name</td><td>Surname</td><td>Response</td><td>Confirmation</td></tr>';
            while($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['StudentID'] . '</td><td>' . $row['Name'] . '</td><td>' . $row['Surname'] . '</td><td>' . $row['Response'] . '</td><td>' . $row['Confirmation'] . '</td></tr>';
            }
            echo '</table>';
        }
        echo '<p>Filter result</p>';
        echo '<form id="filtering" method="get" action="tickets_application.php">';
        echo '<table>';
        echo '<tr><td><input type="radio" name="Response" value="Yes" '; if(isset($_GET['Response'])&&filter_input(INPUT_GET, 'Response')=='Yes') { echo 'checked'; } echo '>Responded</td>';
        echo '<td><input type="radio" name="Response" value="No" '; if(isset($_GET['Response'])&&filter_input(INPUT_GET, 'Response')=='No') { echo 'checked'; } echo '>Unresponded</td></tr>';
        echo '<input type="hidden" name="TicketID" value="'.$_GET['TicketID'].'">';
        echo '<tr><td><input type="radio" name="Confirmation" value="Yes" ';if(isset($_GET['Confirmation'])&&filter_input(INPUT_GET, 'Confirmation')=='Yes') { echo 'checked';} echo '>Confirmed</td>';
        echo '<td><input type="radio" name="Confirmation" value="No" ';if(isset($_GET['Confirmation'])&&filter_input(INPUT_GET, 'Confirmation')=='No') { echo 'checked';} echo '>Unconfirmed</td></tr>';
        echo '<tr><td colspan=2 align="right"><input type="submit" name="submit" value=submit></td></tr>';
        echo '</table>';
        echo '</form>';
        ?>
        <p><a href="home.php">Go Back</a></p>
    </body>
</html>