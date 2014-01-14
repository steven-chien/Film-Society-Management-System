<?php session_start(); if($_SESSION['login']!='1') { header("location:index.php");}?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set("Asia/Hong_Kong");

if(isset($_POST['submit'])) {
    $mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
    for($i=0; $i<sizeof($_POST['Date']); $i++) {
        $time = date('G:i:s',strtotime(filter_input(INPUT_POST, 'Time')));
        $query = sprintf("insert into screening(Date, Time, Title, Venue, Expense) values('%s', '%s', '%s', '%s', %d);", filter_input(INPUT_POST, 'Date'), $time, filter_input(INPUT_POST, 'Title'), filter_input(INPUT_POST, 'Venue'), filter_input(INPUT_POST, 'Expense'));
        $result = $mysql->query($query);
        if(!$result) {
            echo mysqli_error($mysql) . '<br>';
        }
    }
    
    $target = 'images/'.filter_input(INPUT_POST, 'Date');
    if(move_uploaded_file($_FILES['Poster']['tmp_name'], $target)) {
        #echo "The file ".  basename( $_FILES['Poster']['name']). " has been uploaded";
    } else {
        echo "There was an error uploading the file, please try again!";
    }
        
    $redirect = "location:screening.php?Date=".filter_input(INPUT_POST, 'Date');

    header($redirect);
}
