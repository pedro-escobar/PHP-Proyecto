<?php
    session_start();
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Página de retiros</title>
        </head>
        <body>        
            <?php       
                include_once dirname(__FILE__) . '/../Utils/config.php';      
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'cliente'){
                        $flag = true;
                        $cuentae = $montoe = ""; 
                        $message = ""; 
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
                            if(empty($_POST["cuenta"])){
                                $tarjee = "La cuenta es requerida";
                                $flag = false;
                            }
                            if($flag){
                                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                                if (mysqli_connect_errno()) { 
                                    $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                                } 
                                else{
                                    $checkPK = 'SELECT * FROM  CuentaDeAhorros  WHERE Id = '.$_POST["cuenta"];
                                    $resultado = mysqli_query($con, $checkPK);                                                  
                                    if(!mysqli_num_rows($resultado)){
                                        $str_pagina.= '--No tienes Cuentas--';
                                    }
                                    else{
                                        $fila = mysqli_fetch_array($resultado);
                                        if($_POST["monto"]>$fila['javeCoins']){
                                            $message = 'El monto excede el saldo de la cuenta';
                                        }
                                        else{
                                            $resta = $fila['javeCoins']-$_POST["monto"];
                                            $sql = 'UPDATE CuentaDeAhorros set javeCoins='.$resta;
                                            if(mysqli_query($con,$sql)){ 
                                                $message = "saldo actualizado, nuevo monto: ".$resta;
                                            } else{ 
                                                $message = "Error actualizando monto ".mysqli_error($con); 
                                            } 
                                        }
                                    }
                                }
                            }
                        }
                        $str_pagina = "";
                        $str_pagina.= '<h1>has venido a retirar</h1>';
                        $str_pagina.= '<p>Selecciona una de tus cuentas</p>';
                        
                        $str_pagina.= '<form action=" '.$_SERVER['PHP_SELF'].' " method="post">';
                        $str_pagina.= 'Cuenta:';                        
                        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                        if (mysqli_connect_errno()) { 
                            $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                        } 
                        else{
                            $checkPK = 'SELECT * FROM  CuentaDeAhorros  WHERE IdCliente ='.$_SESSION["id"];
                            $resultado = mysqli_query($con, $checkPK);                                                  
                            if(!mysqli_num_rows($resultado)){
                                $str_pagina.= '--No tienes Cuentas--';
                            }
                            else{
                                $str_pagina.= '<select name="cuenta">';
                                while($fila = mysqli_fetch_array($resultado)) {                         
                                    $str_pagina.= '<option value="'.$fila['id'].'"> No '.$fila['id'].'</option>';
                                }
                                $str_pagina.='</select>';                                
                            }                            
                        }                                           
                        $str_pagina.= '<span>'. $cuentae .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Monto a retirar: <input type="num" name="monto" value="';
                        if(isset($_POST["monto"]))  $str_pagina.=$_POST["monto"];
                        $str_pagina.= '"/>';
                        $str_pagina.= '<span>'. $montoe. '</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= '<input type="submit" value="Realizar retiro" name="submit"/>';                      
                        $str_pagina.= '</form>';
                        $str_pagina.= '<br>';
                        $str_pagina.= $message;
                        echo $str_pagina;
                        echo '<a href=http://localhost/PHP-Proyecto/Cliente/index.php> Volver </a><br>';                                     
                    }
                    else if ($_SESSION['rol'] == 'admin'){
                        header("HTTP/1.1 401 Unauthorized");
                    }
                    else{                        
                        header("localhost/PHP-Proyecto/login.php");
                    }
                }
                else{
                    echo '<h1>has venido a comprar</h1>';
                    header("Location: http://localhost/PHP-Proyecto/login.php");
                }
                ?>                                                                                               		
        </body>
    </html>