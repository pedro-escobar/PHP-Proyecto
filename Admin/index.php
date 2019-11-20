<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página principal del proyecto</title>
	</head>
	<body>
		<?php		
			if (isset($_SESSION['rol'])) {
				if ($_SESSION['rol'] == 'admin'){
					echo '<h1>Ventana principal administrador</h1>';
					echo '<a href=http://localhost/PHP-Proyecto/Admin/adminCreditos.php> Administra los créditos </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/Admin/finDeMes.php> Operaciones de Fin de Mes </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/logout.php> Salir </a><br>';
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
<?php
	
?>
