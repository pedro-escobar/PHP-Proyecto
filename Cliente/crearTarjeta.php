<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página creacion de tarjetas</title>
	</head>
	<body>
		<?php		
			echo '<h1>Menú de creación de tarjeta, gestione sus tarjetas aquí</h1>';
			if (isset($_SESSION['rol'])) {
				if ($_SESSION['rol'] == 'cliente'){
                    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                    if (mysqli_connect_errno()) { 
                        $str_pagina.= "Error en la conexión: " . mysqli_connect_error(); 
                    } 
                    else{
                    
                    }
                    $str_todo = "";
                    $str_todo.='<p>Tus tarjetas aprobadas: </p>';
                    $str_todo.='<p>Tus tarjetas pendientes de aprobación: </p>';					
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