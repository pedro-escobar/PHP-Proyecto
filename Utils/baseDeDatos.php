<?php
    //Creacion de Base de datos
    include('./config.php');
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS);
    $sql = 'create database '.NOMBRE_DB;
    if(mysqli_query($con, $sql)){
        echo 'La base de datos '.NOMBRE_DB.' se ha creado correctamente';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con);
    }

?>