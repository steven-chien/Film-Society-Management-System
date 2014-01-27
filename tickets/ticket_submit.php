<html>
    <head>
        <title>Ticket Submit</title>
    </head>
    <body>
        <?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
        <?php

        /* 
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
        session_start();
        date_default_timezone_set('Asia/Hong_Kong');
        
        include("tickets.php");
        $tickets = new tickets(filter_input(INPUT_POST, 'title'), filter_input(INPUT_POST, 'date'),filter_input(INPUT_POST, 'time'), filter_input(INPUT_POST, 'distributor'), filter_input(INPUT_POST, 'venue'), filter_input(INPUT_POST, 'remarks'));
        $tickets->newTickets(filter_input(INPUT_POST, 'quantity'), filter_input(INPUT_POST, 'reserve'));

        $tmp = str_replace(' ', '_', filter_input(INPUT_POST, 'title'));

        $target = '../images/' . $tmp . '.' . substr($_FILES['Poster']['name'], strrpos($_FILES['Poster']['name'], '.')+1);
        
        #echo $target;
        if(move_uploaded_file($_FILES['Poster']['tmp_name'], $target)) {
            #echo "The file ".  basename( $_FILES['Poster']['name']). " has been uploaded";
        } else {
            echo "There was an error uploading the file, please try again!";
        }
        ?>
    </body>
</html>

