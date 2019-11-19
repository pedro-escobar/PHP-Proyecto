<?php
    //Creacion de Usuarios
    include('./config.php');
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table Usuarios (id Int Not Null Auto_Increment, username varchar(60), password varchar(60), rol varchar (30), primary key (id), unique (username));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de usuarios se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table TarjetasCredito (id Int Not Null Auto_Increment, idCliente Int Not Null, cupoMax Int, tasaInteres decimal(10,3), cuotaManejo decimal(10,3), aprobada bit, primary key (id), foreign key (idCliente) references Usuarios(id));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de tarjetas de credito se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table CuentaDeAhorros (id Int Not Null Auto_Increment, idCliente Int Not Null, javeCoins decimal(10,2), primary key (id), foreign key (idCliente) references Usuarios(id));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de cuentas de ahorros se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table Creditos (id Int Not Null Auto_Increment, idCliente Int Null, javeCoins decimal(10,2), fechaPago date, primary key (id), foreign key (idCliente) references Usuarios(id));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de créditos se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }


?>