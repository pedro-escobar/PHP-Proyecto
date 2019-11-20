<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página creacion de tarjetas</title>
	</head>
	<body>
        <?php		
            include_once dirname(__FILE__) . '/../Utils/config.php';
            $tarjee="";
			echo '<h1>Menú de creación de tarjeta, gestione sus tarjetas aquí</h1>';
			if (isset($_SESSION['rol'])) {
				if ($_SESSION['rol'] == 'cliente'){ 
                    $str_pagina="";
                    if(isset($_POST['submit'])){
                        if ($_POST['submit'] == '--Crear una nueva tarjeta--') {
                            $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);                         
                            if (mysqli_connect_errno()) { 
                                $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                            } 
                            else{
                                $sql = 'INSERT INTO TarjetasCredito (idCliente) VALUES ('.$_SESSION['id'].')';                                                                               
                                if(mysqli_query($con,$sql)){ 
                                    $message = "Tarjeta agregada";                                
                                } else{ 
                                    $message = "Error creando tarjeta".mysqli_error($con); 
                                } 
                            }
                        }
                        if ($_POST['submit'] == '--Borrar tarjeta ingresada--') {
                            $flag=true;
                            if(isset($_POST['idtar'])){
                                if(empty($_POST["idtar"])){
                                    $tarjee = "La id de tarjeta es requerida";
                                    $flag = false;
                                }
                                else if(!filter_var($_POST["idtar"], FILTER_VALIDATE_INT)) {
                                    $tarjee = "Formato de tarjeta incorrecto, ingrese solo números";
                                    $flag = false;    
                                }
                                if($flag){
                                    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
                                    if (mysqli_connect_errno()) { 
                                        $str_datos.= "Error en la conexión: " . mysqli_connect_error();
                                    }
                                    $sql = 'DELETE from TarjetasCredito where id='.$_POST['idtar'];
                                    if(mysqli_query($con,$sql)){
                                        $message = "Tarjeta eliminada";
                                        $_POST['idtar'] = "";
                                    } else{ 
                                        $message =  "Error borrando tarjeta".mysqli_error($con); 
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
                        $str_pagina.= 'Ingresa una tarjeta para borrarla: <input type="num" name="idtar" value= " ';
                        if(isset($_POST["idtar"]))  $str_pagina.=$_POST["idtar"];
                        $str_pagina.= '">';
                        $str_pagina.= '<span>'. $tarjee. '</span>';
                        $str_pagina.= '<br>';
                        $str_pagina.= '<input type="submit" value="--Crear una nueva tarjeta--" name="submit" />';  
                        $str_pagina.= '<input type="submit" value="--Borrar tarjeta ingresada--" name="submit" />';
                        $str_pagina.='</form>';
                        $checkPK = 'SELECT * FROM  TarjetasCredito  WHERE IdCliente = '.$_SESSION["id"];
                        $resultado = mysqli_query($con, $checkPK); 
                        $str_tablaTrue="";
                        $str_tablaFalse="";                                                 
                        if(!mysqli_num_rows($resultado)){
                            $str_pagina.= '--No tienes tarjetas registradas ni aprobadas--';
                        }
                        else{                                
                            $str_tablaTrue='<table border="1" style="width:100%"> <tr> <th> Id </th> <th>Cupo Maximo</th> <th>Cuota de Manejo</th> <th>Tasa de Interes</th> </tr>';
                            $str_tablaFalse='<table border="1" style="width:100%"> <tr> <th> Id </th> <th>Aprobado?</th> </tr>';
                            while($fila = mysqli_fetch_array($resultado)) { 
                                if($fila['aprobada']){
                                    $str_tablaTrue.='<tr>';
                                    $str_tablaTrue.= "<td>".$fila['id'].'</td>'.'<td> '.$fila['cupoMax']."</td> <td>".$fila['cuotaManejo']."</td> <td>".$fila['tasaInteres']."</td>";
                                    $str_tablaTrue.= "</tr>"; 
                                }  
                                else{
                                    $str_tablaFalse.='<tr>';
                                    $str_tablaFalse.= "<td>".$fila['id'].'</td>'.'<td> ';
                                    if(!$fila['aprobada']){
                                        $str_tablaFalse.= 'No </td>';
                                    }
                                    $str_tablaFalse.= "</tr>"; 
                                }                                                      
                            }   
                            $str_tablaTrue.= "</table>"; 
                            $str_tablaFalse.= "</table>";                                                           
                        }                         
                        $str_pagina.='<p>Tus tarjetas aprobadas: </p>';
                        $str_pagina.=$str_tablaTrue;
                        $str_pagina.='<p>Tus tarjetas pendientes de aprobación: </p>';
                        $str_pagina.=$str_tablaFalse;
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
				header("Location: /PHP-Proyecto/login.php");
			}
		?>		
	</body>
</html>