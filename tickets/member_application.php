<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Application Record</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        $query = "select * from member where StudentID='".filter_input(INPUT_GET, 'StudentID')."';";
        $result = $mysql->query($query);
        $row = $result->fetch_assoc();
        ?>
        
        <table>
            <tr>
                <td>StudentID</td><td><?php echo $row['StudentID']; ?></td>
            </tr>
            <tr>
                <td>Name</td><td><?php echo $row['Surname'].' '.$row['Name']; ?></td>
            </tr>
            <tr>
                <td>Mobile</td><td><?php echo $row['Mobile']; ?></td>
            </tr>
            <tr>
                <td>Whatsapp</td><td><?php if($row['Whatsapp']==1) echo 'Yes'; else echo 'No'; ?></td>
            </tr>
        </table>
        <P>Application Record</p>
        <?php
        $result->free();
        
        $query = "select TA.TicketID, FT.Title, TA.Timestamp, if(TA.Response=1, 'Successful', 'Failed') as Status, if(TA.Confirmation=1, 'Yes', 'No') as Attendance from tickets_application as TA, free_tickets as FT where FT.TicketID=TA.TicketID and TA.StudentID='".filter_input(INPUT_GET, 'StudentID')."' order by TA.Timestamp;";
        $result = $mysql->query($query);
        if(!$result) {
            die(mysqli_error($mysql));
        }
        
        echo '<table cellpadding="10%">';
        echo '<tr><td>Timestamp</td><td>TicketID</td><td>Title</td><td>Status</td><td>Attendance</td>';
        while($row=$result->fetch_assoc()) {
            echo '<tr><td>'.$row['Timestamp'].'</td><td alignment="right">'.$row['TicketID'].'</td><td>'.$row['Title'].'</td><td>'.$row['Status'].'</td><td>'.$row['Attendance'].'</td></tr>';
        }
        echo '</table>';
        $result->free();
        $mysql->close();
        ?>
        <p><a href="../home.php">Back</a></p>
    </body>
</html>
