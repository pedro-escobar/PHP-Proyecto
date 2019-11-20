<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página principal del proyecto</title>
	</head>
	<body>
		<?php		
			echo '<h1>Ventana principal Cliente</h1>';
			if (isset($_SESSION['rol'])) {
				if ($_SESSION['rol'] == 'cliente'){
					echo '<a href=http://localhost/PHP-Proyecto/crearTarjeta.php> Crea una tarjeta de crédito </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/crearAhorros.php> Abre tu cuenta de ahorros </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/crearCredito.php> Abre un crédito </a><br><br>';
					echo '<a href=http://localhost/PHP-Proyecto/retiro.php> Retira tus JaveCoins </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/comprar.php> Realiza una compra </a><br>';
					echo '<a href=http://localhost/PHP-Proyecto/consignar.php> Consigna dinero a una cuenta </a><br>';
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

