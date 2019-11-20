<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página creacion de cuentas de ahorro</title>
	</head>
	<body>
        <?php		
            include_once dirname(__FILE__) . '/../Utils/config.php';
            $cuentae = $javecoine = "";
			echo '<h1>Menú de creación de cuentas de ahorro, gestione sus cuentas aquí</h1>';
			if (isset($_SESSION['rol'])) {
				if ($_SESSION['rol'] == 'cliente'){ 
                    $str_pagina="";
                    if(isset($_POST['submit'])){
                        if ($_POST['submit'] == '--Crear una nueva cuenta--') {
                            $flag=true;
                            if(isset($_POST['javecoins'])){
                                $filter_options = array( 
                                    'options' => array( 'min_range' => 0) 
                                );
                                if(empty($_POST["javecoins"])){
                                    $javecoine = "El saldo es requerido";
                                    $flag = false;
                                }
                                else if(!filter_var($_POST["javecoins"], FILTER_VALIDATE_FLOAT, $filter_options)) {
                                    $javecoine = "Formato de moneda incorrecto, ingrese solo números mayores a cero";
                                    $flag = false;    
                                }
                                if($flag){
                                    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);                         
                                    if (mysqli_connect_errno()) { 
                                        $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                                    } 
                                    else{
                                        $sql = 'INSERT INTO CuentaDeAhorros (idCliente, javeCoins) VALUES ('.$_SESSION['id'].','.$_POST['javecoins'].')';                                                                               
                                        if(mysqli_query($con,$sql)){ 
                                            $message = "Cuenta agregada"; 
                                            $_POST['cuenta'] = $_POST['javecoins'] ="";                               
                                        } else{ 
                                            $message = "Error creando cuenta".mysqli_error($con); 
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
                        $str_pagina.= 'Saldo Inicial: <input type="num" name="javecoins" value= " ';
                        if(isset($_POST["javecoins"]))  $str_pagina.=$_POST["javecoins"];
                        $str_pagina.= '">';
                        $str_pagina.= '<span>'. $javecoine. '</span><br>';                                                
                        $str_pagina.= '<input type="submit" value="--Crear una nueva cuenta--" name="submit" />';                          
                        $str_pagina.='</form>';
                        $checkPK = 'SELECT * FROM CuentaDeAhorros WHERE IdCliente = '.$_SESSION["id"];
                        $resultado = mysqli_query($con, $checkPK); 
                        $str_tabla="";        
                        $flag=true;                                       
                        if(!mysqli_num_rows($resultado)){
                            $str_pagina.= '--No tienes cuentas asociadas--';
                            $flag=false;
                        }
                        else{                                
                            $str_tabla='<table border="1" style="width:100%"> <tr> <th> Id </th> <th>JaveCoins</th> </tr>';
                            while($fila = mysqli_fetch_array($resultado)) { 
                                $str_tabla.='<tr>';
                                $str_tabla.= "<td>".$fila['id'].'</td>'.'<td> '.$fila['javeCoins']."</td>";
                                $str_tabla.= "</tr>";                                                                                      
                            }   
                            $str_tabla.= "</table>";                                                                                    
                        }              
                        if($flag){
                            $str_pagina.='<p>Tus cuentas asociadas: </p>';
                        }                                   
                        $str_pagina.=$str_tabla;
                        echo $str_pagina;
                        echo '<a href=http://localhost/PHP-Proyecto/Cliente/index.php> Volver </a><br>'; 
                    }                    					
				}
				else{
					echo "Usted no tiene permiso para acceder a esta pagina";
					echo '<br><a href="http://localhost/PHP-Proyecto">Volver al menu</a>';
				}
			}
			else{
				//header("Location: /PHP-Proyecto/login.php");
			}
		?>		
	</body>
</html>