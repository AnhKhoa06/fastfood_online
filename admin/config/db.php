<?php
    $connect = mysqli_connect('localhost','root','','fastfood');
    if($connect){
        mysqli_query($connect, "SET NAMES 'UTF8'");
        
    }else{
        echo 'ket noi that bai';
    }
?>
