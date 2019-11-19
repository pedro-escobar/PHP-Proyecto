<?php
    //Creacion de Usuarios
    include('./config.php');
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table Usuarios (Id Int Not Null Auto_Increment, Username varchar(60), password varchar(60), Rol varchar (30), primary key (Id), unique (Username));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de usuarios se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table TarjetasCredito (Id Int Not Null Auto_Increment, IdCliente Int Not Null, cupoMax Int, tasaInteres decimal(10,3), cuotaManejo decimal(10,3), Aprobada bit, primary key (Id), foreign key (IdCliente) references Usuarios(Id));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de tarjetas de credito se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table CuentaDeAhorros (Id Int Not Null Auto_Increment, IdCliente Int Not Null, JaveCoins decimal(10,2), primary key (Id), foreign key (IdCliente) references Usuarios(Id));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de cuentas de ahorros se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = 'create table Creditos (Id Int Not Null Auto_Increment, IdCliente Int Null, JaveCoins decimal(10,2), fechaPago date, primary key (Id), foreign key (IdCliente) references Usuarios(Id));';
    if(mysqli_query($con, $sql)){
        echo 'La tabla de créditos se ha creado correctamente <br>';
    }
    else{
        echo 'Hubo un error '. mysqli_error($con). ' <br>';
    }


?>