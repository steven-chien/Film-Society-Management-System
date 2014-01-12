<html>
    <head>
        <title>Home</title>
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        
        <?php session_start(); if($_SESSION['login']!='1') { header("location:index.php"); } ?>
        <?php
        /* 
         * To change this license header, choose License Headers in Project Properties.
        * To change this template file, choose Tools | Templates
        * and open the template in the editor.
        */
        
        ?>

        <p>what do you want to do?</p>
        <ul>
            <li>
                <a href="#" id="Tickets">Manage Tickets</a>
                <div id="ticket_menu">
                    <ul>
                        <li><a href="new_tickets.php" >New Tickets</a></li>
                        <li><a href="past_tickets.php" >Past Tickets</a></li>
                    </ul>
                </div>
            </li>
            <li>Manage Library</li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        
        <script type="text/javascript">
            $(document).ready(function() {
                console.log( "ready!" );
                var ticket_click = 0;
                $('#ticket_menu').hide();
                $('#Tickets').click(function() {
                    if(ticket_click==0) {
                        console.log('link clicked');
                        $('#ticket_menu').show();
                        ticket_click = 1;
                    }
                    else {
                        console.log('link clicked');
                        $('#ticket_menu').hide();
                        ticket_click = 0;
                    }
                });
            });
        </script>
    </body>
</html>