<?php
    session_start();
?>
<!DOCtYPE HTML>
<HEAD>
    <title>Login</title>
</HEAD>
<BODY>
    <?php
        echo "<h1> Login </h1>";
        $_SESSION['id'] = null;
        $_SESSION['nomusuario'] = null;
        $_SESSION['rol'] = null;
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
                Nombre usuario: <input type="text" name="nombre" value=\'';
                if (isset($_POST["nombre"])){ 
                    $val = $_POST["nombre"];
                }
                $cadena .= $val.'\'><br>
                Contraseña: <input type="password" name="contrasena" value=\'';
                if (isset($_POST["contrasena"])){ 
                    $val = $_POST["contrasena"];
                }
                $cadena .= $val.'\'><br>
                <input type="submit" value="Iniciar sesion" name = sesion>
                <br>
                <a href="http://localhost/PHP-Proyecto/registro.php">Registrarme</a>
            </form>';
            echo $cadena;
            if (isset($_POST['sesion'])) {
                if (isset($_POST['nombre']) && isset($_POST['contrasena'])) {
                    $sql = "SELECT * FROM usuarios WHERE username='".$_POST['nombre']."'";
                    $resultado = mysqli_query($con,$sql);
                    if(mysqli_num_rows($resultado) > 0){
                        $row = mysqli_fetch_assoc($resultado);
                        $contrasenaa = $row['password'];
                        //echo $contrasenaa;
                        //echo $_POST['contrasena'];
                        if (password_verify($_POST['contrasena'], $contrasenaa)) {
                            // Success!
                            echo "Inicio sesion correctamente";
                            $rol = $row['rol'];
                            echo $rol;
                            if ($rol == 'admin'){
                                //echo "admin";
                                $_SESSION['id'] = null;
                                $_SESSION['nomusuario'] = null;
                                $_SESSION['rol'] = $rol;
                                header("Location: /PHP-Proyecto/Admin/index.php");
                            }
                            if ($rol == 'cliente'){
                                echo "usuario";
                                $_SESSION['id'] = $row['id'];
                                $_SESSION['nomusuario'] = $row['username'];
                                $_SESSION['rol'] = $rol;
                                header("Location: /PHP-Proyecto/Cliente/index.php");

                            }
                        }
                        else {
                            // Invalid credentials
                            echo "La contraseña no es correcta";
                        }
                    }
                    else{
                        echo "El nombre de usuario no existe";
                    }
                }
            }
        }
    ?>
</BODY>