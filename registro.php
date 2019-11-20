<!DOCTYPE HTML>
<HEAD>
    <title>Registro</title>
</HEAD>
<BODY>
    <?php
        echo "<h1> Registro </h1>";
        include_once dirname(__FILE__) . '/Utils/config.php';
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        // Verificar conexión
        if (mysqli_connect_errno())
        {
            echo "Error en la conexión: ". mysqli_connect_error();
        }else{
            $val="";
            $cadena = "";
            $cadena .= '<form action="" method="post">
                Nombre usuario: <input type="text" name="nombre"><br>
                Contraseña: <input type="password" name="contrasena"><br>
                <input type="submit" value="Registrarse" name = registro>
            </form>';
            echo $cadena;
            if (isset($_POST['registro'])) {
                if (isset($_POST['nombre']) && isset($_POST['contrasena'])) {
                    $sql = "SELECT * FROM usuarios WHERE username='".$_POST['nombre']."'";
                    //echo $sql;
                    $resultado = mysqli_query($con,$sql);
                    if(mysqli_num_rows($resultado) < 1){
                        $sql = 'SELECT * FROM usuarios';
                        $resultado = mysqli_query($con,$sql);
                        if(mysqli_num_rows($resultado) > 0){
                            $hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                            //echo $hash;
                            $sql = 'INSERT INTO '."usuarios"." (username ,password, rol) VALUES ('".$_POST['nombre']."','".$hash."','cliente')";
                            //echo $sql;
                            if(mysqli_query($con,$sql)){
                                echo "Cliente creado correctamente";
                                echo '<br><a href="http://localhost/PHP-Proyecto/login.php">Iniciar sesion</a>';
                            }
                            else{
                                echo "Error creando Cliente".mysqli_error($con);
                            }
                        }
                        else{
                            $hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                            $sql = 'INSERT INTO '."usuarios"." (username ,password, rol) VALUES ('".$_POST['nombre']."','".$hash."','"."admin"."')";
                            //echo $sql;
                            if(mysqli_query($con,$sql)){
                                echo "Admin creado correctamente";
                                echo '<br><a href="http://localhost/PHP-Proyecto/login.php">Iniciar sesion</a>';
                            }
                            else{
                                echo "Error creando admin".mysqli_error($con);
                            }
                        }
                    }
                    else{
                        echo "El nombre de usuario ya existe";
                    }
                }
            }
        }
    ?>
</BODY>