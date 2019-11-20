<?php
    session_start();
?>
<!DOCTYPE HTML>
<HEAD>
    <title>Perfil</title>
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
            if (isset($_GET['id']) && isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin'){
                    $sql = "SELECT * FROM creditos WHERE id=".$_GET['id'];
                    $resultado = mysqli_query($con,$sql);
                    if(mysqli_num_rows($resultado) > 0){
                        echo "<h1> Credito </h1>";
                        $row = mysqli_fetch_assoc($resultado);
                        //echo "entro";
                        //echo $row['idCliente'];
                        $cadena = "";
                        $cadena .= '<form action="" method="post">
                        Id: <input type="numeric" disabled name="id" value="'.$row['id'].'"><br>
                        Id Cliente: <input type="numeric" disabled name="idcliente" value="'.$row['idCliente'].'"><br>
                        JaveCoins: <input type="numeric"  disabled name="javecoins" value="'.$row['javeCoins'].'"><br>
                        Fecha pago: <input type="text" disabled name="fechapago" value="'.$row['fechaPago'].'"><br>
                        Correo visitante: <input type="text" disabled name="correovisitante" value="'.$row['correoVisitante'].'"><br>
                        Tasa interes: <input type="numeric" disabled name="tasainteres" value="'.$row['tasaInteres'].'"><br>
                        Tasa interes Mora: <input type="numeric" disabled required name="tasainteresmora" value="'.$row['tasaInteresMora'].'"><br>
                        Aprobado: 
                        <select name="aprobado" size="" required>
                            <option value="0">Rechazado</option>
                            <option value="1">Aprobado</option>
                        </select><br>
                        <input type="submit" value="Guardar" name = guardar>
                        <input type="submit" value="Borrar" name = borrar><br>
                        </form>';
                        echo $cadena;
                        echo '<a href=http://localhost/PHP-Proyecto/Admin/aprobarTarjetas.php> Volver </a><br>';
                        echo '<a href=http://localhost/PHP-Proyecto/logout.php> Logout </a><br>';
                        if (isset($_POST['guardar'])){
                            if (isset($_POST['aprobado'])){
                                $sql = 'UPDATE creditos'." SET aprobado= ".$_POST['aprobado']." WHERE id=".$_GET['id'];
                                if (mysqli_query($con, $sql)) {
                                    echo "Credito guardado correctamente";
                                } else {
                                    echo "Error guardado credito: " . mysqli_error($con);
                                }
                            }
                        }
                    }
                    else{
                        echo "El credito no existe";
                    }
                }
                else {
                    echo "Usted no tiene permiso";
                }
            }
        }
    ?>
</BODY>