		<div class="navigation">
			<ul>
				<li>
					<a href="#">
						<span class="icon"><ion-icon name="car-outline"></ion-icon></span>
						<span class="title">TRANSPORTES JR</span>
					</a>
				</li>
				<li>
					<a href="principal.php">
						<span class="icon"><ion-icon name="home-outline"></ion-icon></span>
						<span class="title">Inicio</span>
					</a>
				</li>
				<?php if ($tipo_usuario == 1) {?>
					<li>
						<a href="controlReclamos.php">
							<span class="icon"><ion-icon name="warning-outline"></ion-icon></span>
							<span class="title">Control Reclamos</span>
						</a>
					</li>
					<li>
						<a href="controlUsuarios.php">
							<span class="icon"><ion-icon name="people-outline"></ion-icon></span>
							<span class="title">Control Usuarios</span>
						</a>
					</li>
					<li>
						<a href="crearUsuarios.php">
							<span class="icon"><ion-icon name="person-add-outline"></ion-icon></span>
							<span class="title">Crear Usuarios</span>
						</a>
					</li>
				<?php } ?>
				<li>
					<a href="logout.php">
						<span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
						<span class="title">Cerrar Sesión</span>
					</a>
				</li>
			</ul>
		</div>