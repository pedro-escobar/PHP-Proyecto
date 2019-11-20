<?php
    session_start();
?>
<!DOCTYPE HTML>
<HEAD>
    <title>Perfil</title>
</HEAD>
<BODY>
    <?php
        echo "<h1> Perfil </h1>";
        include_once dirname(__FILE__) . '/../Utils/config.php'; 
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        // Verificar conexión
        if (mysqli_connect_errno())
        {
            echo "Error en la conexión: ". mysqli_connect_error();
        }else{
            if (isset($_GET['id']) && isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin'){
                    $sql = "SELECT * FROM tarjetascredito WHERE id=".$_GET['id'];
                    $resultado = mysqli_query($con,$sql);
                    if(mysqli_num_rows($resultado) > 0){
                        $row = mysqli_fetch_assoc($resultado);
                        echo "entro";
                        echo $row['idCliente'];
                        /*$cadena = "";
                        $cadena .= '<form action="" method="post">
                            Id: <input type="numeric" disabled name="id" value="'.$row['id'].'"><br>
                            Nombre usuario: <input type="text" disabled name="nombreusuario" value="'.$row['nombreusuario'].'"><br>
                            Rol: 
                            <select name="rol" size="" required>
                                <option value="usuario">usuario</option>
                                <option value="admin">admin</option>
                            </select><br>
                            Cedula: <input type="numeric" disabled name="cedula" value="'.$row['cedula'].'"><br>
                            <input type="submit" value="Guardar" name = guardar>
                            <input type="submit" value="Borrar" name = borrar><br>
                            <input type="submit" value="Salir" name = salir><br>
                            </form>';
                        echo $cadena;
                        if (isset($_POST['guardar'])){
                            if (isset($_POST['rol'])){
                                $sql = 'UPDATE usuarios'." SET rol= '".$_POST['rol']."'";
                                if (mysqli_query($con, $sql)) {
                                    echo "Usuario actualizado correctamente";
                                } else {
                                    echo "Error actualizando persona: " . mysqli_error($con);
                                }
                            }
                        }
                        if (isset($_POST['borrar'])){
                            if (isset($_POST['rol'])){
                                $sql = 'DELETE FROM usuarios'." WHERE id=".$row['id'];
                                if (mysqli_query($con, $sql)) {
                                    echo "Usuario eliminado correctamente";
                                } else {
                                    echo "Error eliminando usuario: " . mysqli_error($con);
                                } 
                            } 
                        }*/
                    }
                }
                else {
                    echo "Usted no tiene permiso";
                }
            }
        }
    ?>
</BODY>