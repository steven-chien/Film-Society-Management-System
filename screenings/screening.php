<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Screening</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        if(isset($_GET['Date'])) {
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            $query = "select * from screening where Date='".filter_input(INPUT_GET, 'Date')."';";
            $result = $mysql->query($query);
            if(!$result) {
                echo mysqli_error($mysql);
            }
            $row = $result->fetch_assoc();
            echo '<table>';
            echo '<tr><td>Date</td><td>'.$row['Date'].'</td></tr>';
            echo '<tr><td>Time</td><td>'.$row['Time'].'</td></tr>';
            echo '<tr><td>Title</td><td>'.$row['Title'].'</td></tr>';
            echo '<tr><td>Venue</td><td>'.$row['Venue'].'</td></tr>';
            echo '<tr><td>Expense</td><td>'.$row['Expense'].'</td></tr>';
            echo '<tr><td>Poster</td><td><a href="../images/'.$row['Date'].'.jpeg">Click here</a></td></tr>';
            $result->free();
            echo '</table>';
            echo '<p>';
            
            $query = "select A.StudentID, M.Name, M.Surname from attendance as A left outer join member as M on M.StudentID=A.StudentID where ScreeningID='".filter_input(INPUT_GET, 'Date')."';";
            #echo $query;
            $result = $mysql->query($query);
            if(!$result) {
                echo mysqli_error($mysql);
            }
            echo '<table>';
            echo '<tr><td>StudentID</td><td>Name</td><td>Surname</td></tr>';
            while($row=$result->fetch_assoc()) {
                echo '<tr><td>'.$row['StudentID'].'</td><td>'.$row['Name'].'</td><td>'.$row['Surname'].'</td></tr>';
            }
            echo '</table>';
            $result->free();
        }
        else {
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            if(!$mysql) {
                echo mysqli_error($mysql);
            }
            
            $query = "select Date, Title from screening;";
            $result = $mysql->query($query);
            if(!$result) {
                echo mysqli_error($mysql);
            }
            echo '<table>';
            echo '<tr><td>Date</td><td>Title</td></tr>';
            while($row = $result->fetch_assoc()) {
                echo '<tr><td>'.$row['Date'].'</td><td><a href="screening.php?Date='.$row['Date'].'">'.$row['Title'].'</a></td></tr>';
            }
            echo '</table>';
            $result->free();
        }
        echo '<p><a href="../home.php">Go Back</a></p>';
        ?>
    </body>
</html>
