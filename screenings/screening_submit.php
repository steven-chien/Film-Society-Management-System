<?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
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
    
    $target = '../images/'.filter_input(INPUT_POST, 'Date').'.jpeg';
    if(move_uploaded_file($_FILES['Poster']['tmp_name'], $target)) {
        #echo "The file ".  basename( $_FILES['Poster']['name']). " has been uploaded";
    } else {
        echo "There was an error uploading the file, please try again!";
    }
    
    require("../PHPMailer-master/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Username = "stevenchien1993@gmail.com";
    $mail->Password = "i:xXitJ#[enb";
    
    $webmaster_email = "elc.pifs@polyu.edu.hk"; 
    #$mail->FromName = "ELC, PIFS";
    $email=filter_input(INPUT_POST, 'Email');
    $name='Receiver';
    $mail->From = $webmaster_email;
    $mail->AddAddress($email,$name);
    $mail->AddReplyTo($webmaster_email,"Squall.f");

    $mail->IsHTML(true);
    $mail->Subject = "Free Preview Tickets of ".filter_input(INPUT_POST, 'Title'); 
    $mail->Body  = "<HTML>";
    $mail->Body .= "<BODY>";
    $mail->Body .= "Dear Film Society Members,";
    $mail->Body .= "<P>We are pleased to let you know that we will be hosting the screening of ".filter_input(INPUT_POST,'Title').".";
    $mail->Body .= "Answer the following question and you may get 2 preview tickets.</P>";
    $mail->Body .= "<p><img src=\"http://myweb.polyu.edu.hk/~ecPIFS/images/". filter_input(INPUT_POST, 'Date').".jpeg\"></P>";
    $mail->Body .= "<p>Details</p>";
    $mail->Body .= "<table>";
    $mail->Body .= "<tr><td>Date</td><td>".filter_input(INPUT_POST, 'Date')."</td></tr>";
    $mail->Body .= "<tr><td>Time</td><td>".filter_input(INPUT_POST, 'Time')."</td></tr>";
    $mail->Body .= "<tr><td>Venue</td><td>".filter_input(INPUT_POST, 'Venue')."</td></tr>";
    $mail->Body .= "<p>Light refreshments will be servied afterwards.";
    $mail->Body .= "<P>";
    $mail->Body .= "Regards,<br>";
    $mail->Body .= "PolyU International Film Society";
    $mail->Body .= "</body>";
    $mail->Body .= "</html>";
    
    $mail->AltBody = "content"; 
    
    if(!$mail->Send()){
        echo "email send error：" . $mail->ErrorInfo;
        //如果有錯誤會印出原因
    }
    else{
        echo "mail sent";
    }
    
    $redirect = "location:screening.php?Date=".filter_input(INPUT_POST, 'Date');

    header($redirect);
}
