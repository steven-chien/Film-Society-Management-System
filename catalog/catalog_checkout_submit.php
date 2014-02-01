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
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php"); } ?>
        <?php
        // put your code here
        if(isset($_POST['submit'])) {
            $mysql = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            if(mysqli_connect_errno()) {
                echo mysqli_connect_error();
                exit();
            }
            
            for($i=1; $i<=3; $i++) {
                if(($_POST["MovieID_$i"])!='') {
                    $query = "select Status from movie where ID='".filter_input(INPUT_POST, "MovieID_$i")."';";
                    #echo $query;
                    $result = $mysql->query($query);
                    if(!$result) {
                        die(mysqli_error($mysql));
                    }
                    $mysql->autocommit(FALSE);
                    $row = $result->fetch_assoc();
                    if($row['Status']>0) {
                        $query = "update movie set Status=Status-1 where ID='".filter_input(INPUT_POST, "MovieID_$i")."';";
                        #echo $query;
                        $mysql->query($query);
                        $query = "insert into loan(StudentID, MovieID) values('".filter_input(INPUT_POST, 'StudentID')."', '".filter_input(INPUT_POST, "MovieID_$i")."');";
                        #echo $query;
                        $mysql->query($query);
                        if(!$mysql->commit()) {
                            die(mysqli_error($mysql));
                        }
                        else {
                            echo '<p>'.filter_input(INPUT_POST, 'MovieID_'.$i).' is checked out!</p>';
                        }   
                    }
                    else {
                        echo '<p>'.filter_input(INPUT_POST, 'MovieID_'.$i).' is not on shelf</p>';
                    }
                    $mysql->autocommit(TRUE);
                    $result->free();
                }
                else {
                    continue;
                }
                
                $mysql->close();
            }
            echo '<p><a href="../home.php">Go Back</a></p>';
        }
        ?>
    </body>
</html>
