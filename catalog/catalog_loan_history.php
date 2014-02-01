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
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        $mysql = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        if(mysqli_connect_errno()) {
            die(mysqli_connect_error());
        }
        $MovieID = mysqli_real_escape_string($mysql, filter_input(INPUT_GET, 'ID'));
        $result = $mysql->query("select * from movie where ID='$MovieID';");
        #echo $MovieID;
        if(!$result) {
            die(mysqli_error($mysql));
        }
        
        $row = $result->fetch_assoc();
        ?>
        <table cellpadding="10%">
            <tr><td>ID</td><td><?php echo $row['ID']; ?></td></tr>
            <tr><td>Year</td><td><?php echo $row['Year']; ?></td></tr>
            <tr><td>Released</td><td><?php echo $row['Released']; ?></td></tr>
            <tr><td>Runtime</td><td><?php echo $row['Runtime']; ?></td></tr>
            <tr><td>Genre</td><td><?php echo $row['Genre']; ?></td></tr>
            <tr><td>Director</td><td><?php echo $row['Director']; ?></td></tr>
            <tr><td>Writer</td><td><?php echo $row['Writer']; ?></td></tr>
            <tr><td>Actor</td><td><?php echo $row['Actor']; ?></td></tr>
            <tr><td>Plot</td><td><?php echo $row['Plot']; ?></td></tr>
            <tr><td>Poster</td><td><a href="<?php echo $row['Poster']; ?>" target="_blank"><?php echo $row['Poster']; ?></a></td></tr>
            <tr><td>Status</td><td><?php echo $row['Status']; ?></td></tr>
            <tr><td>imdb</td><td><a href="<?php echo $row['imdb']; ?>" target="_blank"><?php echo $row['imdb']; ?></a></td></tr>
            <tr><td>Media</td><td><?php if($row['Media']==2) echo 'DVD'; else if($row['Media']==1) echo 'VCD'; else echo 'VHS'; ?></td></tr>
        </table>
        
        <p>Loan History</p>
        
        <?php
        $result->free();
        
        $mysql = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        $query = "select L.LoanID, M.StudentID, M.Surname, M.Name, L.Timestamp as 'Loan', R.Timestamp as 'Return' from loan as L inner join member as M on M.StudentID=L.StudentID left outer join return_loan as R on R.LoanID=L.LoanID where L.MovieID='".$row['ID']."' order by L.Timestamp;";
        $result = $mysql->query($query);
        if(!$result) {
            die(mysqli_error($mysql));
        }
        echo '<table cellpadding="10%">';
        echo '<tr><td>LoanID</td><td>StudentID</td><td>Surname</td><td>Name</td><td>Loan</td><td>Return</td></tr>';
        while($row=$result->fetch_assoc()) {
            echo '<tr><td>'.$row['LoanID'].'</td><td>'.$row['StudentID'].'</td><td>'.$row['Surname'].'</td><td>'.$row['Name'].'</td><td>'.$row['Loan'].'</td><td>'.$row['Return'].'</td></tr>';
        }
        echo '</table>';
        ?>
        <p><a href='../home.php'>Back</a></p>
    </body>
</html>
