<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Application Record</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id();  if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php
        // put your code here
        if(isset($_POST['submit'])&&($_SESSION['ApplicationEdit']=='Yes')) {
            //echo $_SESSION['ApplicationEdit'];
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            for($i=0; $i<sizeof($_POST['StudentID']); $i++) {
                if($_POST['Confirmation'][$i]==1) {
                    $Quantity=2;
                }
                else {
                    $Quantity=0;
                }
                $query = sprintf("update tickets_application set Response=%d, Confirmation=%d, Quantity=%d where TicketID=%d and StudentID='%s';",$_POST['Response'][$i], $_POST['Confirmation'][$i], $Quantity, $_POST['TicketID'], $_POST['StudentID'][$i]);
                #echo $query . '<br>';
                $result = $mysql->query($query);
                if(!$result) {
                    echo 'Unable to update '.$_POST['StudentID'][$i].'<br>';
                }
            }
            $redirect = "location:tickets_application.php?TicketID=".filter_input(INPUT_POST, 'TicketID');
            $_SESSION['ApplicatonEdit'] = NULL;
            header($redirect);
        }
        else if(isset($_GET['TicketID'])) {
            $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
            if(!$mysql) {
                echo mysqli_connect_error();
            }
            $query = sprintf("select TA.StudentID, M.Name, M.Surname, TA.ContactNo, if(TA.Response=1, 'Yes', 'No') as Response, if(TA.Confirmation=1, 'Yes', 'No') as Confirmation, (select sum(TA1.Response) from tickets_application as TA1 where TA.StudentID=TA1.StudentID group by TA1.StudentID) as previous_response, (select sum(TA2.Confirmation) from tickets_application as TA2 where TA.StudentID=TA2.StudentID group by TA2.StudentID) as previous_confirmation from tickets_application as TA left outer join member as M on M.StudentID=TA.StudentID where TA.TicketID=%d",filter_input(INPUT_GET, 'TicketID'));
            #echo $query;
            $result = $mysql->query($query);
            if(!$result) {
                echo mysqli_error($mysql);
            }
            echo '<form name="applicaton_info_edit" method="post" action="ticket_application_record_edit.php">';
            echo '<input type="hidden" name="TicketID" value="'.filter_input(INPUT_GET, 'TicketID').'">';
            echo '<table cellpadding="10">';
            echo '<tr><td>StudentID</td><td>Name</td><td>Surname</td><td>ContactNo.</td><td>Response</td><td>Confirmation</td><td>Previous Response</td><td>Previous Confirmation</td></tr>';
            while($row=$result->fetch_assoc()) {
                #echo $row['StudentID'];
                echo '<tr>';
                echo '<td>'.$row['StudentID'].'<input type="hidden" name="StudentID[]" value="'.$row['StudentID'].'"></td><td>'.$row['Name'].'</td><td>'.$row['Surname'].'</td><td>'.$row['ContactNo'].'</td>';
                echo '<td align="right"><select name="Response[]">';
                if($row['Response']=='Yes') {
                    echo '<option value="1" selected="selected">Yes</option>';
                    echo '<option value="0">No</option>';
                }
                else {
                    echo '<option value="1">Yes</option>';
                    echo '<option value="0" selected="selected">No</option>';
                }
                echo '</select></td>';
                echo '<td align="right"><select name="Confirmation[]">';
                if($row['Confirmation']=='Yes') {
                    echo '<option value="1" selected="selected">Yes</option>';
                    echo '<option value="0">No</option>';
                }
                else {
                    echo '<option value="1">Yes</option>';
                    echo '<option value="0" selected="selected">No</option>';
                }
                echo '</select></td>';
                echo '<td align="right">'.$row['previous_response'].'</td><td align="right">'.$row['previous_confirmation'].'</td>';
                echo '</tr>';
            }
            $_SESSION['ApplicationEdit'] = 'Yes';
            echo '<tr><td colspan="8" align="right"><input type="submit" name="submit" value="submit"></td></tr>';
            echo '</table>';
            echo '</form>';
            $result->free();
            echo '<p><a href="../home.php">Go Back</a></p>';            
        }
        ?>
    </body>
</html>
