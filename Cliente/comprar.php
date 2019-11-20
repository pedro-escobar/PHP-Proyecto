<?php
    session_start();
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Página de compras</title>
        </head>
        <body>        
            <?php       
                include_once dirname(__FILE__) . '/../Utils/config.php';      
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'cliente'){
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
                            if($flag){
                                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                                if (mysqli_connect_errno()) { 
                                    $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                                } 
                                else{
                                    $checkPK = 'SELECT * FROM  TarjetasCredito  WHERE Id = '.$_POST["tarjeta"];
                                    $resultado = mysqli_query($con, $checkPK);                                                  
                                    if(!mysqli_num_rows($resultado)){
                                        $str_pagina.= '--No tienes Tarjetas--';
                                    }
                                    else{
                                        $fila = mysqli_fetch_array($resultado);
                                        if($_POST["monto"]>($fila['cupoMax'])+$fila['sobreCupo']){
                                            $message = 'El monto excede el cupo maximo de la tarjeta junto al sobrecupo';
                                        }
                                        else{                                            
                                            $sql = 'INSERT INTO Compras (idTarjeta, valorCompra, Cuotas) VALUES ('.$_POST["tarjeta"].', '.$_POST["monto"].', '.$_POST["cuotas"].')';
                                            if(mysqli_query($con,$sql)){ 
                                                $message = "compra realizada: ".$resta;
                                            } else{ 
                                                $message = "Error realizando compra ".mysqli_error($con); 
                                            } 
                                        }
                                    }
                                }
                            }
                        }
                        $str_pagina = "";
                        $str_pagina.= '<h1>has venido a comprar</h1>';
                        $str_pagina.= '<p>Selecciona una de tus tarjetas</p>';
                        
                        $str_pagina.= '<form action=" '.$_SERVER['PHP_SELF'].' " method="post">';
                        $str_pagina.= 'Tarjeta:';                        
                        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                        if (mysqli_connect_errno()) { 
                            $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                        } 
                        else{
                            $checkPK = 'SELECT * FROM  TarjetasCredito  WHERE IdCliente = '.$_SESSION["id"];
                            $resultado = mysqli_query($con, $checkPK);                                                  
                            if(!mysqli_num_rows($resultado)){
                                $str_pagina.= '--No tienes tarjetas--';
                            }
                            else{
                                $str_pagina.= '<select> name="tarjeta"';
                                while($fila = mysqli_fetch_array($resultado)) {
                                    if($fila['aprobada']){
                                        $str_pagina.= '<option value="'.$fila['Id'].'> Tarjeta Id '.$fila['Id'].'</option>';
                                    }                                                             
                                }
                                $str_pagina.='</select>';                                
                            }                            
                        }                                           
                        $str_pagina.= '<span>'. $tarjee .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Cuotas:';     
                                                       
                        $str_pagina.= '<select name="cuotas"> ';
                        for ($i = 1; $i <= 6; $i++) {                         
                            $str_pagina.= '<option value="'.$i.'"> '.$i.' Meses </option>';
                        }
                        $str_pagina.='</select>';                                                                                                                                
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Moneda usada en la compra: ';
                        $str_pagina.= '<input type="radio" name="moneda" value="javecoin" ';
                        if(isset($_POST["moneda"]) && $_POST["moneda"]=="javecoin") $str_pagina.='checked="checked"';
                        $str_pagina.= '> Javecoin';
                        $str_pagina.= '<input type="radio" name="moneda" value="pesos"';
                        if(isset($_POST["moneda"]) && $_POST["moneda"]=="pesos") $str_pagina.='checked="checked"';
                        $str_pagina.='> Pesos';
                        $str_pagina.= '<br>';
                        $str_pagina.= '<span> '. $monedae .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Cantidad a pagar: <input type="num" name="monto" value= " ';
                        if(isset($_POST["monto"]))  $str_pagina.=$_POST["monto"];
                        $str_pagina.= '"/>';
                        $str_pagina.= '<span>'. $montoe. '</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= '<input type="submit" value="Comprar" name="submit" />';                      
                        $str_pagina.= '</form>';
                        $str_pagina.= '<br>';  
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
