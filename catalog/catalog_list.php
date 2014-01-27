<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Catalog</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        $query = "select ID, Title, Year, Director, if(Media=2, 'DVD', if(Media=1, 'VCD', 'VHS')) as Media, Status from movie order by ID;";
        $result = $mysql->query($query);     
        if(!$result) {
            die(mysqli_error($mysql));
        }
        
        echo '<table>';
        echo '<tr><td>ID</td><td>Title</td><td>Year</td><td>Director</td><td>Media</td><td>Qty Available</td></td>';
        while($row=$result->fetch_assoc()) {
            echo '<tr><td>'.$row['ID'].'</td><td>'.$row['Title'].'</td><td>'.$row['Year'].'</td><td>'.$row['Director'].'</td><td>'.$row['Media'].'</td><td>'.$row['Status'].'</td></tr>';
        }
        echo '</table>';
        ?>
        <p><a href='../home.php'>Back</a></p>
    </body>
</html>
