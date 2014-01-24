<html>
    <head>
        <title>home</title>
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
      <?php

        /* 
        * To change this license header, choose License Headers in Project Properties.
        * To change this template file, choose Tools | Templates
        * and open the template in the editor.
        */

       #if(!isset($_SESSION['login'])) {
           $user = filter_input(INPUT_POST, 'user');
           $password = filter_input(INPUT_POST, 'password');
            $mysql = mysqli_connect("localhost", 'web', '123456', "film_society");
            if(mysqli_connect_errno()) {
                die(mysqli_connect_error());
            }
            else {
		$query = "select User from login where User='".$user."' and Password=password('".$password."');";
		$result = $mysql->query($query);
            	if(!$result) {
                    echo mysqli_error($mysql);
            	}
            	$row = $result->fetch_assoc();
		if($row['User']!=$user) {
		    header("location:index.php");
                }
                else {
                    session_start();
                    $_SESSION['user'] = 'web';
                    $_SESSION['password'] = '123456';
                    $_SESSION['host'] = 'localhost';
                    $_SESSION['db'] = 'film_society';
            
                    $_SESSION['login'] = "1";
                    header("location:home.php");
                }
            }
       
       ?>
    </body>
</html>
