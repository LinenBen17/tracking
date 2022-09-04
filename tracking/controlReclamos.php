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
	<title>Control Usuarios | Transportes JR</title>
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
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
					<span><?php echo htmlspecialchars($nombre); ?> </span><ion-icon name="person-circle-outline"></ion-icon>
				</div>
			</div>
			<div class="details">
				<div class="recentOrders">
					<div class="cardHeader">
						<h2>Control Reclamos</h2>
					</div><br>
					<table id="table" class="table-striped table-bordered">
					    <thead>
					        <tr>
					            <th>#</th>
					            <th>Nombre Cliente</th>
					            <th>Teléfono Cliente</th>
					            <th>Correo Cliente</th>
					            <th>No. Guía</th>
					            <th>Foto Guía</th>
					            <th>Foto Producto</th>
					            <th>Carta Reclamo</th>
					            <th>Estado Activo</th>
					        </tr>
					    </thead>
					    <tbody>
							
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready( function () {
	        $('#table').DataTable({
	        	language: {
			        "decimal": "",
			        "emptyTable": "No hay información",
			        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
			        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
			        "infoPostFix": "",
			        "thousands": ",",
			        "lengthMenu": "Mostrar _MENU_ Entradas",
			        "loadingRecords": "Cargando...",
			        "processing": "Procesando...",
			        "search": "Buscar:",
			        "zeroRecords": "Sin resultados encontrados",
			        "paginate": {
			            "first": "Primero",
			            "last": "Ultimo",
			            "next": "Siguiente",
			            "previous": "Anterior"
			        }
			    },
				"ajax":{
					"method": "POST",
					"url": "reclamos.php",
				},
				"columns":[
					{"data": "id"},
					{"data": "nombre_cliente"},
					{"data": "telefono_cliente"},
					{"data": "correo_cliente"},
					{"data": "numero_guia"},
					{"data": "foto_guia"},
					{"data": "foto_producto"},
					{"data": "carta_reclamo"},
					{"data": "estado"}
				]
	        });
    	});
	</script>
	<?php require 'scripts.php'; ?>
</body>