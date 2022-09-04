<?php 
    ini_set('display_errors', 0);
    error_reporting(E_ALL);

    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['id'])) {
        header("location: index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
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
		<?php require 'navigation.php'; ?>
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
					<span><?php echo htmlspecialchars($nombre); ?></span><ion-icon name="person-circle-outline"></ion-icon>
				</div>
			</div>
			<div class="details">
				<div class="recentOrders">
					<div class="cardHeader">
						<h2>Tracking Guía</h2>
					</div>
					<div class="inputBx">
						<form method="POST">
							<label>Introduce el número de guía:</label><br>
							<input type="text" name="noguia">
							<input type="submit" class="btn" value="Consultar">
						</form>
						<?php
						    if ($_POST) {
						    	$noguia = $_POST['noguia'];

						    	$sql_descarga_camiones = "SELECT escaneo, fecha, responsabl, manifiesto, rutaingres FROM descargacamiones WHERE escaneo = ?";
						    	$sql_carga_camiones = "SELECT escaneo, fecha, responsabl, manifiesto, rutadestin FROM cargacamiones WHERE escaneo = ?";
						    	$sql_envios = "SELECT no_guia, fecha, responsabl, manifiesto, destino, rutaingres, fecharecib, fechapago FROM envios WHERE no_guia = ?";

						    	if ($sentencia_rows_descarga = $mysqli->prepare($sql_descarga_camiones) and $sentencia_rows_carga = $mysqli->prepare($sql_carga_camiones) and $sentencia_rows_envios = $mysqli->prepare($sql_envios)) {
						    		$sentencia_rows_descarga->bind_param("s", $noguia);
						    		$sentencia_rows_descarga->execute();
						    		$sentencia_rows_descarga->store_result();

						    		$sentencia_rows_carga->bind_param("s", $noguia);
						    		$sentencia_rows_carga->execute();
						    		$sentencia_rows_carga->store_result();

						    		$sentencia_rows_envios->bind_param("s", $noguia);
						    		$sentencia_rows_envios->execute();
						    		$sentencia_rows_envios->store_result();

						    		$num_rows_descarga = $sentencia_rows_descarga->num_rows;
						    		$num_rows_carga = $sentencia_rows_carga->num_rows;
						    		$num_rows_envios = $sentencia_rows_envios->num_rows;

						    		if ($num_rows_descarga > 0 or $num_rows_carga > 0 or $num_rows_envios > 0) {
						    			$sentencia_rows_descarga->close();
						    			$sentencia_rows_carga->close();
						    			$sentencia_rows_envios->close();

						    			$sentencia_assoc_descarga = $mysqli->prepare($sql_descarga_camiones);
						    			$sentencia_assoc_descarga->bind_param("s", $noguia);
						    			$sentencia_assoc_descarga->execute();

						    			$result_descarga = $sentencia_assoc_descarga->get_result();
						    			$assoc_descarga = $result_descarga->fetch_assoc();

						    			$sentencia_assoc_descarga->close();

						    			$sentencia_assoc_carga = $mysqli->prepare($sql_carga_camiones);
						    			$sentencia_assoc_carga->bind_param("s", $noguia);
						    			$sentencia_assoc_carga->execute();

						    			$result_carga = $sentencia_assoc_carga->get_result();
						    			$assoc_carga = $result_carga->fetch_assoc();

						    			$sentencia_assoc_carga->close();

										$sentencia_assoc_envios = $mysqli->prepare($sql_envios);
						    			$sentencia_assoc_envios->bind_param("s", $noguia);
						    			$sentencia_assoc_envios->execute();

						    			$result_envios = $sentencia_assoc_envios->get_result();
						    			$assoc_envios = $result_envios->fetch_assoc();

						    			$sentencia_assoc_envios->close();
						?>
					</div>
					<div class="cardHeader">
						<h2>Ingreso Camiones</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>No. Guía</td>
								<td>Fecha</td>
								<td>Manifiesto</td>
								<td>Ruta Ingreso</td>
								<td>Responsable</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php if($assoc_descarga['escaneo'] != NULL){ echo htmlspecialchars($assoc_descarga['escaneo']); } ?></td>
								<td><?php if($assoc_descarga['fecha'] != NULL){ echo htmlspecialchars($assoc_descarga['fecha']); } ?></td>
								<td><?php if($assoc_descarga['manifiesto'] != NULL){ echo htmlspecialchars($assoc_descarga['manifiesto']); } ?></td>
								<td><?php if($assoc_descarga['rutaingres'] != NULL){ echo htmlspecialchars($assoc_descarga['rutaingres']); } ?></td>
								<td><?php if($assoc_descarga['responsabl'] != NULL){ echo htmlspecialchars($assoc_descarga['responsabl']); } ?></td>
							</tr>
						</tbody>
					</table>
					<div class="cardHeader">
						<h2>Salida Camiones</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>No. Guía</td>
								<td>Fecha</td>
								<td>Manifiesto</td>
								<td>Ruta Destino</td>
								<td>Responsable</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php if($assoc_carga['escaneo'] != NULL){ echo htmlspecialchars($assoc_carga['escaneo']); } ?></td>
								<td><?php if($assoc_carga['fecha'] != NULL){ echo htmlspecialchars($assoc_carga['fecha']); } ?></td>
								<td><?php if($assoc_carga['manifiesto'] != NULL){ echo htmlspecialchars($assoc_carga['manifiesto']); } ?></td>
								<td><?php if($assoc_carga['rutadestin'] != NULL){ echo htmlspecialchars($assoc_carga['rutadestin']); } ?></td>
								<td><?php if($assoc_carga['responsabl'] != NULL){ echo htmlspecialchars($assoc_carga['responsabl']); } ?></td>
							</tr>
						</tbody>
					</table>
					<div class="cardHeader">
						<h2>Envios</h2>
					</div>
					<table>
						<thead>
							<tr>
								<td>No. Guía</td>
								<td>Fecha</td>
								<td>Fecha Recibe</td>
								<td>Fecha Pago</td>
								<td>Manifiesto</td>
								<td>Ruta Destino</td>
								<td>Ruta Ingreso</td>
								<td>Responsable</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php if($assoc_envios['no_guia'] != NULL){ echo htmlspecialchars($assoc_envios['no_guia']); } ?></td>
								<td><?php if($assoc_envios['fecha'] != NULL){ echo htmlspecialchars($assoc_envios['fecha']); } ?></td>
								<td><?php if($assoc_envios['fecharecib'] != NULL){ echo htmlspecialchars($assoc_envios['fecharecib']); } ?></td>
								<td><?php if($assoc_envios['fechapago'] != NULL){ echo htmlspecialchars($assoc_envios['fechapago']); } ?></td>
								<td><?php if($assoc_envios['manifiesto'] != NULL){ echo htmlspecialchars($assoc_envios['manifiesto']); } ?></td>
								<td><?php if($assoc_envios['destino'] != NULL){ echo htmlspecialchars($assoc_envios['destino']); } ?></td>
								<td><?php if($assoc_envios['rutaingres'] != NULL){ echo htmlspecialchars($assoc_envios['rutaingres']); } ?></td>
								<td><?php if($assoc_envios['responsabl'] != NULL){ echo htmlspecialchars($assoc_envios['responsabl']); } ?></td>
							</tr>
						</tbody>
					</table>
					<?php
									}else{
					?>
										<div class="errorGuia">
											<span class="status pending">No se encontraron resultados con ese número de guía.</span>
										</div>
					<?php
							    		}
							    	}
							    }
					?>
				</div>
			</div>
		</div>
	</div>

	<?php require 'scripts.php'; ?>
</body>
</html>