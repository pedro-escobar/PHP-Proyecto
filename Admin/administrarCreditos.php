<?php
    session_start();
?>
<!DOCTYPE HTML>
<HEAD>
    <title>Listado</title>
</HEAD>
<BODY>
    <?php
        include_once dirname(__FILE__) . '/../Utils/config.php'; 
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        // Verificar conexión
        if (mysqli_connect_errno())
        {
            echo "Error en la conexión: ". mysqli_connect_error();
        }else{
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin'){
                    $sql = "SELECT * FROM creditos";
                    $resultado = mysqli_query($con,$sql);
                    echo "<h1> Administrar creditos </h1>";
                    if(mysqli_num_rows($resultado) > 0){
                        $str_datos = "";
                        $str_datos.='<table border="1" style="width:100%">';
                        $str_datos.='<tr>';
                        $str_datos.='<th>Id</th>';
                        $str_datos.='<th>Id cliente</th>';
                        $str_datos.='<th>JaveCoins</th>';
                        $str_datos.='<th>Fecha pago</th>';
                        $str_datos.='<th>Correo visitante</th>';
                        $str_datos.='<th>Tasa interes</th>';
                        $str_datos.='<th>Tasa interes mora</th>';
                        $str_datos.='<th>Aprobado</th>';
                        $str_datos.='</tr>';
                        while($fila = mysqli_fetch_array($resultado)) {
                            $str_datos.='<tr>';
                            $str_datos.= "<td>".'<a href="http://localhost/PHP-Proyecto/Admin/verCredito.php/?id='.$fila['id'].'">'.$fila['id'].'</a>'."</td> <td>".$fila['idCliente'].'</td> <td>'.$fila['javeCoins'].'</td> <td>'.$fila['fechaPago']."</td> <td>".$fila['correoVisitante']."</td> <td>".$fila['tasaInteres']."</td> <td>".$fila['tasaInteresMora']."</td> <td>".$fila['aprobado']."</td>";
                            $str_datos.= "</tr>";
                        }
                        $str_datos.= "</table>";
                        echo $str_datos;
                        echo '<a href="http://localhost/PHP-Proyecto/Admin/index.php"> Volver </a><br>';
                        echo '<a href="http://localhost/PHP-Proyecto/logout.php"> Logout </a><br>';
                    }
                    else{
                        echo "No hay creditos en el sistema.<br>";
                        echo '<a href="http://localhost/PHP-Proyecto/Admin/index.php"> Volver </a><br>';
                        echo '<a href="http://localhost/PHP-Proyecto/logout.php"> Logout </a><br>';
                    }
                }
            }
        }
    ?>
</BODY>