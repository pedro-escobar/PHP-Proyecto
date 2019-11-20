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
                    $sql = "SELECT * FROM creditos WHERE aprobado IS NULL";
                    $resultado = mysqli_query($con,$sql);
                    echo "<h1> Creditos con aprobacion pendiente </h1>";
                    if(mysqli_num_rows($resultado) > 0){
                        $cadena ="";
                        $cadena .='<ul>';
                        while($fila = mysqli_fetch_array($resultado)) {
                            $cadena .='<li><a href="http://localhost/PHP-Proyecto/Admin/decidirCreditoAprobado.php/?id='.$fila['id'].'">'. "Tarjeta de credito con Id ".$fila['id'].'</a>'.' --> Pendiente aprobación'.'</li>';
                        }
                        $cadena .='</ul>';
                        echo $cadena;
                    }
                    else{
                        echo "No hay aprobaciones pendientes.<br>";
                    }
                    echo '<a href=http://localhost/PHP-Proyecto/Admin/index.php> Volver </a><br>';
                    echo '<a href=http://localhost/PHP-Proyecto/logout.php> Logout </a><br>';
                }
            }
        }
    ?>
</BODY>