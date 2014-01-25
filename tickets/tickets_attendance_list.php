<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        if(!isset($_GET['TicketID'])) {
            header('location:../index.php');
        }
        else {
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            $query = "select TA.StudentID, M.Name, M.Surname, TA.ContactNo from tickets_application as TA left outer join member as M on M.StudentID=TA.StudentID where TA.TicketID=".filter_input(INPUT_GET, 'TicketID')." and TA.Confirmation=1";
            $result = $mysql->query($query);
            
            if(!$result) {
                die(mysqli_error($mysql));
            }
            else {
                echo '<table>';
                echo '<tr><td>StudentID</td><td>Surname</td><td>Name</td><td>ContactNo.</td></tr>';
                while($row=$result->fetch_assoc()) {
                    echo '<tr><td>'.$row['StudentID'].'</td><td>'.$row['Surname'].'</td><td>'.$row['Name'].'</td><td>'.$row['ContactNo'].'</td></tr>';
                    
                }
                echo '</table>';
            }
        }
        ?>
    </body>
</html>
