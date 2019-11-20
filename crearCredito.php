<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página creacion de créditos</title>
	</head>
	<body>
        <?php		
            include_once dirname(__FILE__) . '/../Utils/config.php';
            $fechapagoe = $javecoine = $message = "";
			echo '<h1>Menú de creación de créditos</h1>';
			if (isset($_SESSION['rol'])) {
				if ($_SESSION['rol'] == 'cliente'){ 
                    $str_pagina="";
                    if(isset($_POST['submit'])){
                        if ($_POST['submit'] == '--Crear un nuevo credito--') {
                            $flag=true;
                            if(isset($_POST['javecoins'])){
                                $filter_options = array( 
                                    'options' => array( 'min_range' => 0) 
                                );
                                if(empty($_POST["javecoins"])){
                                    $javecoine = "El monto es requerido";
                                    $flag = false;
                                }
                                else if(!filter_var($_POST["javecoins"], FILTER_VALIDATE_FLOAT, $filter_options)) {
                                    $javecoine = "Formato de monto incorrecto, ingrese solo números mayores a cero";
                                    $flag = false;    
                                }
                                if($flag){
                                    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);                         
                                    if (mysqli_connect_errno()) { 
                                        $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                                    } 
                                    else{
                                        $tasa = 5;
                                        if(empty($_POST['tasainteres'])){
                                            $tasa = $_POST['tasainteres'];
                                        }
                                        $date=date("Y-m-d",strtotime($_POST['fechapago']));
                                        $sql = 'INSERT INTO Creditos (idCliente, fechaPago, javeCoins, tasaInteres) VALUES ('.$_SESSION['id'].','.$date.', '.$_POST['javecoins'].', '.$tasa.')';                                                                               
                                        if(mysqli_query($con,$sql)){ 
                                            $message = "Credito agregado"; 
                                            $_POST['fechaPago'] = $_POST['javecoins'] ="";                               
                                        } else{ 
                                            $message = "Error creando credito".mysqli_error($con).$date; 
                                        } 
                                    }
                                }  
                            }                           
                        }
                    }                    
                    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);                 
                    if (mysqli_connect_errno()) { 
                        $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                    } 
                    else{
                        $str_pagina.= '<form action=" '.$_SERVER['PHP_SELF'].' " method="post">';
                        $str_pagina.= 'Monto: <input type="num" name="javecoins" value= "';
                        if(isset($_POST["javecoins"]))  $str_pagina.=$_POST["javecoins"];
                        $str_pagina.= '">';
                        $str_pagina.= '<span>'. $javecoine. '</span><br>'; 
                        $str_pagina.= 'fecha de Pago: <input type="date" name="fechapago" value= "';
                        if(isset($_POST["fechapago"]))  $str_pagina.=$_POST["fechapago"];
                        $str_pagina.= '">';
                        $str_pagina.= '<span>'. $fechapagoe. '</span><br>'; 
                        $str_pagina.= 'Proponer tasa de interes: <input type="num" name="tasainteres" value= "';
                        if(isset($_POST["tasainteres"]))  $str_pagina.=$_POST["tasainteres"];
                        $str_pagina.= '">';
                        $str_pagina.= '<span>'. $javecoine. '</span><br>';                                               
                        $str_pagina.= '<input type="submit" value="--Crear un nuevo credito--" name="submit" />';                          
                        $str_pagina.='</form>';
                        echo $str_pagina;
                        echo $message;
                        echo '<a href=http://localhost/PHP-Proyecto/Cliente/index.php> Volver </a><br>'; 
                    }                    					
				}
				
			}
			else{
                $correoe="";
                $str_pagina="";
                if(isset($_POST['submit'])){
                    if ($_POST['submit'] == '--Crear un nuevo credito--') {
                        $flag=true;
                        if(isset($_POST['javecoins'])){
                            $filter_options = array( 
                                'options' => array( 'min_range' => 0) 
                            );
                            if(empty($_POST["javecoins"])){
                                $javecoine = "El monto es requerido";
                                $flag = false;
                            }
                            else if(!filter_var($_POST["javecoins"], FILTER_VALIDATE_FLOAT, $filter_options)) {
                                $javecoine = "Formato de monto incorrecto, ingrese solo números mayores a cero";
                                $flag = false;    
                            }
                            if(empty($_POST["correo"])){
                                $correoe = "El correo es requerido";
                                $flag = false;
                            }
                            if($flag){
                                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);                         
                                if (mysqli_connect_errno()) { 
                                    $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                                } 
                                else{
                                    $tasa = 5;
                                    $date=date("Y-m-d",strtotime($_POST['fechapago']));
                                    $sql = 'INSERT INTO Creditos (correoVisitante, fechaPago, javeCoins, tasaInteres) VALUES ("'.$_POST['correo'].'",'.$date.', '.$_POST['javecoins'].', '.$tasa.')';                                                                               
                                    if(mysqli_query($con,$sql)){ 
                                        $message = "Credito agregado"; 
                                        $_POST['fechaPago'] = $_POST['javecoins'] ="";                               
                                    } else{ 
                                        $message = "Error creando credito".mysqli_error($con).$date; 
                                    } 
                                }
                            }  
                        }                           
                    }
                }                    
                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);                 
                if (mysqli_connect_errno()) { 
                    $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                } 
                else{
                    $str_pagina.= '<form action=" '.$_SERVER['PHP_SELF'].' " method="post">';
                    $str_pagina.= 'Email: <input type="email" name="correo" value= "';
                    if(isset($_POST["correo"]))  $str_pagina.=$_POST["correo"];
                    $str_pagina.= '">';
                    $str_pagina.= '<span>'. $correoe. '</span><br>';
                    $str_pagina.= 'Monto: <input type="num" name="javecoins" value= "';
                    if(isset($_POST["javecoins"]))  $str_pagina.=$_POST["javecoins"];
                    $str_pagina.= '">';
                    $str_pagina.= '<span>'. $javecoine. '</span><br>'; 
                    $str_pagina.= 'fecha de Pago: <input type="date" name="fechapago" value= "';
                    if(isset($_POST["fechapago"]))  $str_pagina.=$_POST["fechapago"];
                    $str_pagina.= '">';
                    $str_pagina.= '<span>'. $fechapagoe. '</span><br>';                                               
                    $str_pagina.= '<input type="submit" value="--Crear un nuevo credito--" name="submit" />';                          
                    $str_pagina.='</form>';
                    echo $str_pagina;
                    echo $message;
                    echo '<a href=http://localhost/PHP-Proyecto/Cliente/index.php> Volver </a><br>'; 
                }                    					
            }
		?>		
	</body>
</html>