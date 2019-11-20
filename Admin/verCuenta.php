<!DOCRYPE HTML>
<HEAD>
    <title>Perfil</title>
</HEAD>
<BODY>
    <?php
        echo "<h1> Perfil </h1>";
        session_start();
        include_once dirname(__FILE__) . '/../Utils/config.php';
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        // Verificar conexión
        if (mysqli_connect_errno())
        {
            echo "Error en la conexión: ". mysqli_connect_error();
        }else{
            if (isset($_GET['id']) && isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin'){
                    $sql = "SELECT * FROM cuentadeahorros WHERE id=".$_GET['id'];
                    $resultado = mysqli_query($con,$sql);
                    if(mysqli_num_rows($resultado) > 0){
                        $row = mysqli_fetch_assoc($resultado);
                        $cadena = "";
                        $cadena .= '<form action="" method="post">
                            Id: <input type="numeric" disabled name="id" value="'.$row['id'].'"><br>
                            Id Cliente: <input type="numeric" disabled name="idcliente" value="'.$row['idCliente'].'"><br>
                            JaveCoins: <input type="numeric" name="javecoins" value="'.$row['javeCoins'].'"><br>
                            <input type="submit" value="Guardar" name = guardar>
                            <input type="submit" value="Borrar" name = borrar><br>
                            </form>';
                        echo $cadena;
                        echo '<a href=http://localhost/PHP-Proyecto/Admin/administrarUsuarios.php> Volver </a><br>';
                        echo '<a href=http://localhost/PHP-Proyecto/logout.php> Logout </a><br>';
                        if (isset($_POST['guardar'])){
                            if (isset($_POST['javecoins'])){
                                $sql = 'UPDATE cuentadeahorros'." SET javeCoins= ".$_POST['javecoins']." WHERE id= ".$row['id'];
                                if (mysqli_query($con, $sql)) {
                                    header("Location: http://localhost/PHP-Proyecto/Admin/administrarCuentas.php");
                                } else {
                                    echo "Error actualizando cuenta: " . mysqli_error($con);
                                }
                            }
                        }
                        if (isset($_POST['borrar'])){
                            if (isset($_POST['javecoins'])){
                                $sql = 'DELETE FROM cuentadeahorros'." WHERE id=".$row['id'];
                                if (mysqli_query($con, $sql)) {
                                    header("Location: http://localhost/PHP-Proyecto/Admin/administrarCuentas.php");
                                } else {
                                    echo "Error eliminando cuenta: " . mysqli_error($con);
                                } 
                            } 
                        }
                    }
                    else {
                        echo "La cuenta con ese id no existe";
                    }
                }
                else {
                    echo "Usted no tiene permiso";
                }
            }
        }
    ?>
</BODY>