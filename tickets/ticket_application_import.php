<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Import Tickets application</title>
    </head>
    <body>
        <?php session_start(); if($_SESSION['login']!='1') { header("location:index.php");}?>
        <?php
        // put your code here
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        if(!$mysql) {
            echo mysqli_connect_error();
        }
        
        $query = "select TicketID, Title from free_tickets;";
        $result = $mysql->query($query);
        if(!$result) {
            echo mysqli_error($mysql);
        }
        $i = 0;
        while($row=$result->fetch_assoc()) {
            $TicketInfo[$i][0] = $row['TicketID'];
            $TicketInfo[$i][1] = $row['Title'];
            $i++;
        }
        $result->free();
        ?>
        <form name="application" method="post" enctype="multipart/form-data" action="ticket_application_submit.php">
            <table>
                <tr>
                    <td>Ticket Title</td>
                    <td>
                        <select name="TicketID">
                            <?php for($j=0; $j<$i; $j++) {
                                    echo '<option value="'.$TicketInfo[$j][0].'">'.$TicketInfo[$j][1].'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>CSV file</td>
                    <td><input name="CSV" type="file" id="file"></td>
                </tr>
                <tr>
                    <td>Timestamp Column</td><td align="right"><input type="text" value="0" name="Timestamp"></td>
                </tr>
                <tr>
                    <td>StudentID Column</td><td align="right"><input type="text" value="1" name="StudentID"></td>
                </tr>
                <tr>
                    <td>Answer Column</td><td align="right"><input type="text" value="3" name="Answer"></td>
                </tr>
                <tr>
                    <td>Response Column</td><td align="right"><input type="text" value="6" name="Response"></td>
                </tr>
                <tr>
                    <td>Confirmation Column</td><td align="right"><input type="text" value="7" name="Confirmation"></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" value="submit" name="submit"></td>
                </tr>
            </table>
        </form>
    </body>
</html>
