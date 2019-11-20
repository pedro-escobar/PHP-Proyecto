<?php
    session_start();
?>
<!DOCTYPE HTML>
<HEAD>
    <title>Listado</title>
</HEAD>
<BODY>
    <?php
        session_start();
        include_once dirname(__FILE__) . '/../Utils/config.php'; 
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        // Verificar conexión
        if (mysqli_connect_errno())
        {
            echo "Error en la conexión: ". mysqli_connect_error();
        }else{
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin'){
                    $sql = "SELECT * FROM tarjetascredito WHERE aprobada IS NULL";
                    $resultado = mysqli_query($con,$sql);
                    echo "<h1> Creditos con aprobacion pendiente </h1> <br>";
                    $cadena ="";
                    $cadena .='<ul>';
                    while($fila = mysqli_fetch_array($resultado)) {
                        $cadena .='<li><a href="http://localhost/PHP-Proyecto/Admin/decidirAprobado.php/?id='.$fila['id'].'">'.$fila['id'].'</a>'.'Pendiente aprobación'.'</li>';
                    }
                    $cadena .='</ul>';
                    echo $cadena;
                }
            }
        }
    ?>
</BODY>