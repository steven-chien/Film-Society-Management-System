<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Input Screening Attendance</title>
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php"); } ?>
        <?php
        // put your code here
        if(!isset($_POST['submit'])) {
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            $query = "select Date, Title from screening;";
            $result = $mysql->query($query);
            if(!$result) {
                echo mysqli_error($mysql);
            }
        }
        else {
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            for($i=0; $i<sizeof($_POST['StudentID']); $i++) {
                $query = sprintf("insert into attendance(ScreeningID, StudentID) values('%s', '%s')", filter_input(INPUT_POST, 'Date'), $_POST['StudentID'][$i]);
                $result = $mysql->query($query);
                if(!$result) {
                    echo mysqli_error($mysql);
                }
            }
            $redirect = "location:screening.php?Date=".filter_input(INPUT_POST, 'Date');

            header($redirect);
        }
        ?>
        <form name="attendance" method="post" action="screening_attendance.php">
            <table id="attendance">
                <tr><td>Title</td><td><select name="Date"><?php while($row=$result->fetch_assoc()) { echo '<option value="'.$row['Date'].'">'.$row['Title'].'</option>'; } $result->free(); ?></select></td></tr>
                <div id="fields">
                <tr>
                    <td>1</td><td><input type="text" name="StudentID[]"></td>
                </tr>
                </div>
            </table>
            <input type="button" id="add" value="Add More"><input name="submit" type="submit">
        </form>
        
        <script type="text/javascript">
            $(document).ready(function() {
                console.log( "ready!" );
                console.log($('#attendance tr').size());
                $('#add').click(function() {
                    var i = ($('#attendance tr').size());
                    $('#attendance > tbody:last').append('<tr><td>'+i+'</td><td><input type="text" name="StudentID[]"></td></tr>');
                    i++;
                    console.log(i);
                    return false;
                });
            });
	</script>
    </body>
</html>
