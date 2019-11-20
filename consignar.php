<?php
    session_start();
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Página de consignar creditos</title>
        </head>
        <body>        
            <?php       
                include_once dirname(__FILE__) . '/Utils/config.php';      
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'cliente'){
                        $flag = true;
                        $cuentae = $montoe = $monedae = ""; 
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
                            if(empty($_POST["moneda"])){
                                $monedae = "Elige una denominacion";
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
                                    $checkPK = 'SELECT * FROM  Creditos  WHERE Id = '.$_POST["cuenta"];
                                    $resultado = mysqli_query($con, $checkPK);                                                  
                                    if(!mysqli_num_rows($resultado)){
                                        $str_pagina.= '--No hay Creditos--';
                                    }
                                    else{
                                        $monto = $_POST["monto"];
                                        if($_POST["moneda"]=='pesos'){
                                            $monto/=1000;
                                        }
                                        $fila = mysqli_fetch_array($resultado);
                                        if($monto>$fila['javeCoins']){//no debe ser fijo
                                            $message = "no consignar mas de la cuenta, al menos ".$fila['javeCoins'];
                                        }
                                        else{
                                                                                                                                                                                             
                                            $suma = $fila['javeCoins']-$monto;
                                            $sql = 'UPDATE Creditos set javeCoins='.$suma. ' where id = '.$_POST["cuenta"];
                                            if(mysqli_query($con,$sql)){ 
                                                $message = "saldo actualizado, queda por pagar : ".$suma;
                                            } else{ 
                                                $message = "Error actualizando monto ".mysqli_error($con); 
                                            } 
                                        }
                                                                                
                                    }
                                }
                            }
                        }
                        $str_pagina = "";
                        $str_pagina.= '<h1>has venido a consignar a un credito</h1>';
                        $str_pagina.= '<p>Selecciona un credito</p>';
                        
                        $str_pagina.= '<form action=" '.$_SERVER['PHP_SELF'].' " method="post">';
                        $str_pagina.= 'Credito:';                        
                        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                        if (mysqli_connect_errno()) { 
                            $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                        } 
                        else{
                            $checkPK = 'SELECT * FROM  Creditos';
                            $resultado = mysqli_query($con, $checkPK);                                                  
                            if(!mysqli_num_rows($resultado)){
                                $str_pagina.= '--No hay creditos para consignar--';
                            }
                            else{
                                $str_pagina.= '<select name="cuenta">';
                                while($fila = mysqli_fetch_array($resultado)) {  
                                    if(isset($fila['correoVisitante'])){
                                        $str_pagina.= '<option value="'.$fila['id'].'"> No '.$fila['id'].'</option>';
                                    }
                                    if($fila['aprobado']){
                                        $str_pagina.= '<option value="'.$fila['id'].'"> No '.$fila['id'].'</option>';
                                    }                                                           
                                }
                                $str_pagina.='</select>';                                
                            }                            
                        }                                           
                        $str_pagina.= '<span>'. $cuentae .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Moneda usada en la consignacion: ';
                        $str_pagina.= '<input type="radio" name="moneda" value="javecoin" ';
                        if(isset($_POST["moneda"]) && $_POST["moneda"]=="javecoin") $str_pagina.='checked="checked"';
                        $str_pagina.= '> Javecoin';
                        $str_pagina.= '<input type="radio" name="moneda" value="pesos"';
                        if(isset($_POST["moneda"]) && $_POST["moneda"]=="pesos") $str_pagina.='checked="checked"';
                        $str_pagina.='> Pesos';
                        $str_pagina.= '<br>';
                        $str_pagina.= '<span> '. $monedae .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Monto a consignar: <input type="num" name="monto" value="';
                        if(isset($_POST["monto"]))  $str_pagina.=$_POST["monto"];
                        $str_pagina.= '"/>';
                        $str_pagina.= '<span>'. $montoe. '</span>';
                        $str_pagina.= '<br>';                        
                        $str_pagina.= '<input type="submit" value="Consignar" name="submit"/>';                      
                        $str_pagina.= '</form>';
                        $str_pagina.= '<br>';
                        $str_pagina.= $message;
                        echo $str_pagina;
                        echo '<br><a href=http://localhost/PHP-Proyecto/Cliente/index.php> Volver </a><br>';                                     
                    }
                }
                else{
                    $flag = true;
                        $cuentae = $montoe = $monedae = $cedulae=''; 
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
                            if(empty($_POST["moneda"])){
                                $monedae = "Elige una denominacion";
                                $flag = false;
                            }
                            if(empty($_POST["cedula"])){
                                $cedulae = "La cedula es requerida";
                                $flag = false;
                            }
                            if($flag){
                                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                                if (mysqli_connect_errno()) { 
                                    $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                                } 
                                else{
                                    $checkPK = 'SELECT * FROM  Creditos  WHERE Id = '.$_POST["cuenta"];
                                    $resultado = mysqli_query($con, $checkPK);                                                  
                                    if(!mysqli_num_rows($resultado)){
                                        $str_pagina.= '--No tienes Creditos--';
                                    }
                                    else{
                                        $monto = $_POST["monto"];
                                        if($_POST["moneda"]=='pesos'){
                                            $monto/=1000;
                                        }
                                        $fila = mysqli_fetch_array($resultado);
                                        if($monto>$fila['javeCoins']){//no debe ser fijo
                                            $message = "no consignar mas de la cuenta, al menos ".$fila['javeCoins'];
                                        }
                                        else{
                                            
                                            $suma = $fila['javeCoins']-$monto;
                                            $sql = 'UPDATE Creditos set javeCoins='.$suma. ' where id = '.$_POST["cuenta"];
                                            if(mysqli_query($con,$sql)){ 
                                                $message = "credito actualizado, nuevo monto faltante: ".$suma;
                                            } else{ 
                                                $message = "Error actualizando monto del credito ".mysqli_error($con); 
                                            } 
                                        }
                                                                                
                                    }
                                }
                            }
                        }
                        $str_pagina = "";
                        $str_pagina.= '<h1>has venido a consignar a un credito</h1>';
                        $str_pagina.= '<p>Selecciona un credito de la lista</p>';
                        
                        $str_pagina.= '<form action=" '.$_SERVER['PHP_SELF'].' " method="post">';
                        $str_pagina.= 'Credito:';                        
                        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                        if (mysqli_connect_errno()) { 
                            $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                        } 
                        else{
                            $checkPK = 'SELECT * FROM  Creditos';
                            $resultado = mysqli_query($con, $checkPK);                                                  
                            if(!mysqli_num_rows($resultado)){
                                $str_pagina.= '--No hay creditos para consignar--';
                            }
                            else{
                                $str_pagina.= '<select name="cuenta">';
                                while($fila = mysqli_fetch_array($resultado)) {
                                    if(isset($fila['correoVisitante'])){
                                        $str_pagina.= '<option value="'.$fila['id'].'"> No '.$fila['id'].'</option>';
                                    }  
                                    else if($fila['aprobado']){
                                        $str_pagina.= '<option value="'.$fila['id'].'"> No '.$fila['id'].'</option>';
                                    }                                                           
                                }
                                $str_pagina.='</select>';                                
                            }                            
                        }                                           
                        $str_pagina.= '<span>'. $cuentae .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Moneda usada en la consignacion: ';
                        $str_pagina.= '<input type="radio" name="moneda" value="javecoin" ';
                        if(isset($_POST["moneda"]) && $_POST["moneda"]=="javecoin") $str_pagina.='checked="checked"';
                        $str_pagina.= '> Javecoin';
                        $str_pagina.= '<input type="radio" name="moneda" value="pesos"';
                        if(isset($_POST["moneda"]) && $_POST["moneda"]=="pesos") $str_pagina.='checked="checked"';
                        $str_pagina.='> Pesos';
                        $str_pagina.= '<br>';
                        $str_pagina.= '<span> '. $monedae .'</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Monto a consignar: <input type="num" name="monto" value="';
                        if(isset($_POST["monto"]))  $str_pagina.=$_POST["monto"];
                        $str_pagina.= '"/>';
                        $str_pagina.= '<span>'. $montoe. '</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= 'Cedula: <input type="num" name="cedula" value="';
                        if(isset($_POST["cedula"]))  $str_pagina.=$_POST["cedula"];
                        $str_pagina.= '"/>';
                        $str_pagina.= '<span>'. $cedulae. '</span>';
                        $str_pagina.= '<br>';                         
                        $str_pagina.= '<input type="submit" value="Consignar" name="submit"/>';                      
                        $str_pagina.= '</form>';
                        $str_pagina.= '<br>';
                        $str_pagina.= $message;
                        echo $str_pagina;
                        echo '<br><a href=http://localhost/PHP-Proyecto/index.php> Volver </a><br>'; 
                }
                ?>                                                                                               		
        </body>
    </html>