<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Past Tickets</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php"); } ?>
        <?php
        // put your code here
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);

	$queryString = sprintf("SELECT * FROM free_tickets");
	$result = $mysql->query($queryString);
	if(!$result) {
            die(mysql_error());
	}
	echo '<table cellpadding="10%" width="70%">';
	echo '<tr><td>TicketID</td><td>Title</td><td>Date</td><td>Time</td><td>Venue</td><td>Distributor</td><td>Quantity</td><td>Reserve</td><td>Qty Available</td><td>Given Out<td>Remarks</td></tr>';
	while($row=$result->fetch_assoc()) {
            $queryString = sprintf("select Name from venue where VenueID=%d", $row['VenueID']);
            $tempResult = $mysql->query($queryString);
            $rowVenue = $tempResult->fetch_assoc();
            $venueName = $rowVenue['Name'];
            $tempResult->free();
            
            $queryString = sprintf("select Company from distributor where DistributorID=%d", $row['DistributorID']);
            $tempResult = $mysql->query($queryString);
            $rowDistributor = $tempResult->fetch_assoc();
            $distributorName = $rowDistributor['Company'];
            $tempResult->free();
            
            $queryString = "select sum(Quantity) as TotalGaveOut from tickets_application where TicketID='".$row['TicketID']."';";
            $tempResult = $mysql->query($queryString);
            $rowGaveoutQuantity = $tempResult->fetch_assoc();
            $gaveoutQuantity = $rowGaveoutQuantity['TotalGaveOut'];
            $tempResult->free();
            
            echo '<tr><td>' . $row['TicketID'] . '</td><td><a href="tickets_application.php?TicketID=' . $row['TicketID'] . '" >' . $row['Title'] . '</a></td><td>' . $row['Date'] . '</td><td>' . $row['Time'] . '</td><td>' . $venueName . '</td><td>' . $distributorName . '</td><td>' . $row['Quantity'] . '</td><td>'. $row['Reserve'] . '</td><td>' . ($row['Quantity']-$row['Reserve']) . '</td><td>' . $gaveoutQuantity . '</td><td>' . $row['Remarks'] . '</td></tr>';
	}
        $result->free();
	echo '</table>';
        echo '<table>';
        echo '<tr><td><a href="../home.php">Go Back</a></td><td><a href="ticket_application_record_edit.php">Edit</a></td></tr>';
        echo '</table>';
        ?>
    </body>
</html>
