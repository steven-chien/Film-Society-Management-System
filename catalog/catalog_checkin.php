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
        if(isset($_POST['MovieID'])&&$_POST['MovieID']!='') {
            $mysql = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            if(mysqli_connect_errno()) {
                die(mysqli_connect_error());
            }
            
            $query = "select LoanID from loan where MovieID='".filter_input(INPUT_POST, 'MovieID')."' and LoanID not in (select LoanID from return_loan);";
            if(!($result=$mysql->query($query))) {
                die(mysqli_error($mysql));
            }
            $row = $result->fetch_assoc();
            if($row['LoanID']==NULL) {
                die("invalid Loan");
            }
            else {
                $LoanID = $row['LoanID'];
                #echo $LoanID;
            }
            
            $mysql->autocommit(FALSE);
            $query = "update movie set Status=Status+1 where ID='".filter_input(INPUT_POST, 'MovieID')."';";
            $mysql->query($query);
            $query = "insert into return_loan(LoanID) values('$LoanID');";
            #echo $query;
            $mysql->query($query);
            if(!$mysql->commit()) {
                die(mysqli_error($mysql));
            }
            else {
                echo 'Return Successful';
            }
            $_POST['MovieID'] = NULL;
            $result->free();
            $mysql->close();
        }
        ?>
        <form name="return_loan" method="post" action="catalog_checkin.php">
            <table>
                <tr><td>MovieID</td><td><input type="text" name="MovieID"></td></tr>
                <tr><td colspan="2"><input type="submit" name="submit" value="submit"></td></tr>
            </table>
        </form>
        <p><a href='../home.php'>Back</a></p>
    </body>
</html>
