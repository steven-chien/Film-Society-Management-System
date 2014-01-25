<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tickets
 *
 * @author steven
 */
session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}

class tickets {
    private $TicketID;
    private $Title;
    private $Date;
    private $Time;
    private $Venue;
    private $Member = array();
    private $Quantity;

    public function __construct($Title, $Date, $Time, $Distributor, $Venue, $Remarks) {
        $this->Title = $Title;
        $this->Date = $Date;
        $this->Time = date('G:i:s',strtotime($Time));
        $this->Time;
        $this->Distributor = $Distributor;
        $this->Venue = $Venue;
        $this->Remarks = $Remarks;
    }

    public function newTickets($quantity) {
        $this->Quantity = $quantity;
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        if(mysqli_connect_errno()) {
            die(mysqli_connect_error());
        }
        
        $queryString = sprintf("INSERT INTO free_tickets(Title, Date, Time, VenueID, DistributorID, Quantity, Remarks) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $this->Title, $this->Date, $this->Time, $this->Venue, $this->Distributor, $this->Quantity, $this->Remarks);
        $mysql->query($queryString);

        $queryString = sprintf("SELECT TicketID, Title, Date, Time, VenueID, DistributorID, Remarks, Quantity FROM free_tickets WHERE Title='%s' AND Date='%s'", $this->Title, $this->Date);
        $result = $mysql->query($queryString);
        
        $row = $result->fetch_assoc();
        $this->TicketID = $row['TicketID'];
        $dbTitle = $row['Title'];
        $dbDate = $row['Date'];
        $dbTime = $row['Time'];
        $dbQuantity = $row['Quantity'];
        $dbRemarks = $row['Remarks'];
        $result->free();
        
        $queryString = sprintf("select Name from venue where VenueID=%d", $this->Venue);
        $result = $mysql->query($queryString);
        if(!$result) {
            die(mysqli_error());
        }
        $row = $result->fetch_assoc();
        $venueName = $row['Name'];
        $result->free();
        
        $queryString = sprintf("select Company from distributor where DistributorID=%d", $this->Distributor);
        $result = $mysql->query($queryString);
        if(!$result) {
            die(mysqli_error());
        }
        $row = $result->fetch_assoc();
        $distrubtorName = $row['Company'];
        $result->free();
        
        $mysql->close();
        echo '<p>New free tickets have been recorded</p>';
        echo '<table cellspacing="15%">';
        echo '<tr><td width="15%">TicketID</td><td>' . $this->TicketID . '</td></tr>';
        echo '<tr><td>Title</td><td>' . $dbTitle . '</td></tr>';
        echo '<tr><td>Date</td><td>' . $dbDate . '</td></tr>';
        echo '<tr><td>Time</td><td>' . $dbTime . '</td></tr>';
        echo '<tr><td>Venue</td><td>' . $venueName . '</td></tr>';
        echo '<tr><td>Quantity</td><td>' . $dbQuantity . '</td></tr>';
        echo '<tr><td>Remarks</td><td>' . $dbRemarks . '</td></tr>';
        echo '<tr><td>Poster</td><td><a href="images/'.str_replace(' ', '_', $dbTitle).'.jpeg" target="_blank">Click here</a></td></tr>';
        echo '</table>';
        echo '<p><a href="../home.php">Go Back</a></p>';
    }
}

class loadTickets extends tickets {
    public function __construct($date) {
        $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
        $queryString = sprintf("SELECT TicketID, Title, Date, Time, Venue, Quantity FROM tickets WHERE Date='%s'", $date);
        $result = $mysql->query($queryString);
        $row = $result->fetch_assoc();
        $this->TicketID = $row['TicketID'];
        $this->Title = $row['Title'];
        $this->Date = $row['Date'];
        $this->Time = $row['Time'];
        $this->Venue = $row['Venue'];
        $this->Quantity = $row['Quantity'];
        $mysql->close();
    }
}


