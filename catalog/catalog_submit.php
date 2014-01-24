<?php session_start(); session_regenerate_id(); if($_SESSION['login']!='1') { header("location:../index.php");}?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['submit']))
{
    include_once("movie.class.php");
    date_default_timezone_set("Asia/Hong_Kong");
    $mysql = mysqli_connect('localhost', 'web', '123456', 'film_society');
    if(!$mysql) {
        echo mysqli_connect_error();
    }
    $file = fopen($_FILES['file']['tmp_name'], 'r');
    $header = NULL;
    $false_count = 0;
    $success_count = 0;
    
    $Title_col = filter_input(INPUT_POST, 'Title_col');
    $ID_col = filter_input(INPUT_POST, 'ID_col');
    $Year_col = filter_input(INPUT_POST, 'Year_col');
    $Qty_col = filter_input(INPUT_POST, 'Qty_col');
    
    if(!is_numeric($Title_col)||!is_numeric($ID_col)||!is_numeric($Year_col)||!is_numeric($Qty_col)) {
        die('columns must be in int');
    }
    
    while($row=fgetcsv($file, 1000, ',')) {
        if(!$header) {
            $header = $row;
        }
        else {
            $movieID = $row[$ID_col];
            $title = $row[$Title_col];
            $year = $row[$Year_col];
            $Qty = $row[$Qty_col];
            
            
            $film = new movie($movieID, filter_input(INPUT_POST, 'Media'), $title, $Qty, $year);
            try {
                $film->parse();
                $film->storeData();
                $success_count++;
            } catch (Exception $ex) {
                $false_count++;
                echo $ex.'<br>';
            }
        }

    }
    echo $success_count . ' successful import<br>';
    echo $false_count . ' failed import</br>';
}
?>
