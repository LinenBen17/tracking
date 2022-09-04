<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['id'])) {
        header("location: index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
	$correcto = false;

    if (isset($_POST['id'])) {
    	$id = $_POST['id'];
		$usuario = $_POST['usuario'];
		$nombre = $_POST['nombre'];

		$sql = "UPDATE usuarios SET usuario = ?, nombre = ? WHERE id = ?";

		$sentencia = $mysqli->prepare($sql);
		$sentencia->bind_param("ssi", $usuario, $nombre, $id);
		$exec = $sentencia->execute();

		if ($exec) {
			$correcto = true;
			header("Location:controlUsuarios.php");
			die();
		}
    }else{
    	$usuario = $_POST['usuario'];
    	$nombre = $_POST['nombre'];
    	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    	$tipo_usuario = $_POST['tipo_usuario'];

    	$sql = "INSERT INTO usuarios (id, usuario, password, nombre, tipo_usuario) VALUES (NULL, ?, ?, ?, ?)";

    	$sentencia = $mysqli->prepare($sql);
    	$sentencia->bind_param("sssi", $usuario, $password, $nombre, $tipo_usuario);
    	$exec = $sentencia->execute();

    	if ($exec) {
			$correcto = true;
			header("Location:controlUsuarios.php");
			die();
    	}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>
	<div class="container">
		<?php require 'navigation.php' ?>
		<!-- Main -->
		<div class="main">
			<div class="topbar">
				<div class="toggle">
					<ion-icon name="menu-outline"></ion-icon>
				</div>
				<!-- search -->
				<div class="search">
					<label>
						<input type="text" placeholder="Search here">
						<ion-icon name="search-outline"></ion-icon>
					</label>
				</div>
				<!-- userImg -->
				<div class="user">
					<span><?php echo $nombre; ?></span><ion-icon name="person-circle-outline"></ion-icon>
				</div>
			</div>
			<div class="details">
				<div class="recentOrders">
					<div class="cardHeader">
						<h2>Confirmación</h2>
					</div>
					<?php if ($correcto == false) { ?>
						<div class="errorGuia">
							<span class="status pending">Hubo un error al realizar la consulta. ¡Intentalo de nuevo!</span>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php require 'scripts.php' ?>
</body>
</html>