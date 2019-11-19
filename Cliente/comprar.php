<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Página principal del proyecto</title>
        </head>
        <body>
            <?php	
                include_once dirname(__FILE__) . '/../Utils/config.php'; 
                $flag = true;
                $tarjee = $monedae = $montoe = "";  
                $options = array('options' => array('min_range' => 0));
                if(isset($_POST['submit'])){                
                    if(empty($_POST["monto"])){
                        $montoe = "Ingresa un monto";
                        $flag = false;
                    }
                    else if(!filter_var($_POST["monto"], FILTER_VALIDATE_FLOAT, $options)) {
                        $montoe = "Formato de monto incorrecto, ingrese solo números mayores a cero";
                        $flag = false;    
                    }
                    if(empty($_POST["moneda"])){
                        $monedae = "Elige una denominacion";
                        $flag = false;
                    }
                    if(empty($_POST["tarjeta"])){
                        $tarjee = "La tarjeta es requerida";
                        $flag = false;
                    }
                }
                echo '<h1>has venido a comprar</h1>';
                echo '<p>Selecciona una de tus tarjetas</p>';
            ?>
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    Tarjeta:
                    <?php
                        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                        if (mysqli_connect_errno()) { 
                            echo "Error en la conexión: " . mysqli_connect_error(); 
                        } 
                        else{
                            $checkPK = 'SELECT * FROM  TarjetasCredito  WHERE IdCliente = '.$_SESSION["Id"];
                            $resultado = mysqli_query($con, $checkPK);                                                  
                            if(!mysqli_num_rows($resultado)){
                                echo '--No tienes tarjetas--';
                            }
                            else{
                                $str_datos = '<select> name="tarjeta"';
                                while($fila = mysqli_fetch_array($resultado)) {                         
                                    $str_datos.= '<option value="'.$fila['Id'].'> Tarjeta Id '.$fila['Id'].'</option>';
                                }
                                $str_datos.='</select>';
                                echo $str_datos;
                            }                            
                        }
                    ?>                    
                    <span> <?php echo $tarjee?></span>
                    <br>
                    Cuotas:     
                        <?php                            
                            $str_datos = '<select> ';
                            for ($i = 1; $i <= 6; $i++) {                         
                                $str_datos.= '<option value="'.$i.'"> '.$i.' Meses </option>';
                            }
                            $str_datos.='</select>';
                            echo $str_datos;                            
                        ?>                                                   
                    <br>
                    Moneda a retirar: 
                    <input type="radio" name="moneda" value="javecoin" <?php if(isset($_POST["moneda"]) && $_POST["moneda"]=="javecoin") echo 'checked="checked"'; ?>> Javecoin
                    <input type="radio" name="moneda" value="pesos" <?php if(isset($_POST["moneda"]) && $_POST["moneda"]=="pesos") echo 'checked="checked"'; ?>> Pesos
                    <br>
                    <span> <?php echo $monedae?></span>
                    <br>
                    Monto: <input type="num" name="monto" value=<?php if(isset($_POST["monto"])) echo $_POST["monto"]; ?>>
                    <span> <?php echo $montoe?></span>
                    <br>                    
                    <input type="submit" value="Comprar" name="submit" />                      
                </form>
                <br>                                                		
        </body>
    </html>
