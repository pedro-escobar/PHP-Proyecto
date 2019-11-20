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
					echo '<a href=http://localhost/PHP-Proyecto/Admin/administrarUsuarios.php> Administrar usuarios </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/Admin/administrarCuentas.php> Administrar cuentas de ahorro </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/Admin/administrarCreditos.php> Administrar Creditos </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/Admin/aprobarTarjetas.php> Aprobar trajetas </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/Admin/aprobarCreditos.php> Aprobar creditos </a><br>';
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
