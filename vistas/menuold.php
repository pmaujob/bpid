<?php
session_start();
//if (!isset($_SESSION['usuario'])) {
  //  header('location:http://localhost/bpid/');
//} else {
    //  echo "Existe una sesion";

    ?>
<script type="text/javascript">
	/*
		*activador para menu
		*/
		$(document).ready(function()
		{
			$(".button-collapse").sideNav();
		});

		function mostrarMenu(parametro)
		{
			switch(parametro)
			{
				case 1: 		$( "#inicio" ).toggle("slow");				break;
				case '1oculto':	$( "#inicioOculto" ).toggle("slow");		break;
				case 2: 		$( "#radicacion" ).toggle("slow");			break;
				case '2oculto':	$( "#radicacionOculto" ).toggle("slow");	break;
				case 3: 		$( "#viabilidad" ).toggle("slow");			break;
				case '3oculto': $( "#viabilidadOculto" ).toggle("slow");	break;
				case 4: 		$( "#controlposterior" ).toggle("slow");	break;
				case '4oculto': $( "#controlposteriorOculto" ).toggle("slow");break;
				case 5: 		$( "#actualizacion" ).toggle("slow");		break;
				case '5oculto': $( "#actualizacionOculto" ).toggle("slow"); break;
				case 6: 		$( "#ejecucion" ).toggle("slow");			break;
				case '6oculto':	$( "#ejecucionOculto" ).toggle("slow");		break;
				case 7: 		$( "#consultas" ).toggle("slow");			break;
				case '7oculto':	$( "#consultasOculto" ).toggle("slow");		break;
				case 8: 		$( "#configuraciones" ).toggle("slow");			break;
				case '8oculto':	$( "#configuracionOculto" ).toggle("slow");		break;
			}

		}
		function ocultarMenu(parametro)
		{
			switch(parametro)
			{
				case 1.1:
				case 1.11:$( "#inicio" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break
				case 1.2:
				case 1.22:$( "#inicio" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/formularios/frm_radicar.php";break
				case 1.3:
				case 1.33:$( "#inicio" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break
				case 2.1:
				case 2.11:$( "#radicacion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/formularios/frm_radicar.php";break;
				case 2.2:
				case 2.22:$( "#radicacion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/formularios/frm_listas_radicar.php";break;
				case 2.3:
				case 2.33:$( "#radicacion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/formularios/frm_certificado_radicar.php";break;
				case 3.1:
				case 3.11:$( "#viabilidad" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 3.2:
				case 3.22:$( "#viabilidad" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 3.3:
				case 3.33:$( "#viabilidad" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 4.1:
				case 4.11:$( "#controlposterior" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 4.2:
				case 4.22:$( "#controlposterior" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 4.3:
				case 4.33:$( "#controlposterior" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 5.1:
				case 5.11:$( "#actualizacion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 5.2:
				case 5.22:$( "#actualizacion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 5.3:
				case 5.33:$( "#actualizacion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 6.1:
				case 6.11:$( "#ejecucion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 6.2:
				case 6.22:$( "#ejecucion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 6.3:
				case 6.33:$( "#ejecucion" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 7.1:
				case 7.11:$( "#consultas" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 7.2:
				case 7.22:$( "#consultas" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 7.3:
				case 7.33:$( "#consultas" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;
				case 8.1:
				case 8.11:$( "#configuraciones" ).toggle("slow");window.location.href="http://localhost/bpid/vistas/index.php";break;

			}

		}

	</script>
	<div class="container-fluid">
		<div class="row ">
			<div class="col s12 m12 l12 barra" >
				<label id="nombresesionsup" >
					<?php
echo strtoupper($_SESSION['usuario']); ?>
					<a href=<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/bpid/controlador/cerrar.php' ?>>CERRAR SESIÓN</a>

				</label>
				<label id="fechasupederecha">
					<?php date_default_timezone_set("America/Bogota");
    echo strftime(" FECHA: %F HORA: %T");
    ?>
				</label></div>
			</div>
		</div>
		<nav class="hide-on-large-only">
			<div class="nav-wrapper light-green darken-2">
				<a href="#!" data-activates="mobile-demo">Mostrar Menú</a>


			<a href="#" class="brand-logo right"><i class="material-icons">settings</i></a>
			<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

			<ul class="side-nav" id="mobile-demo">
				<div class="menuizquierda">
					<!--menu oculto cuando la pantalla se hace pequeña-->
					<ul id="ulizquierdo">
						<li class="opciones"><div class="imgul" onclick="ocultarMenu(1.11)">INICIO</div></li>

						<!--
						<div id="inicioOculto">
							<li class="opciones opcionesli" onclick="ocultarMenu(1.11)"><div class="imgul">REGISTRAR</div></li>
							<li class="opciones opcionesli" onclick="ocultarMenu(1.22)"><div class="imgul">ACTUALIZAR</div></li>
							<li class="opciones opcionesli" onclick="ocultarMenu(1.33)"><div class="imgul">BUSCAR</div></li>
						</div>
					-->
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('2oculto')">RADICACIÓN</div></li>
					<div id="radicacionOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(2.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(2.22)"><div class="imgul">LISTA DE CHEQUEO</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(2.33)"><div class="imgul">GENERAR CERTIFICADO</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('3oculto')">VIABILIDAD</div></li>
					<div id="viabilidadOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(3.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(3.22)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(3.33)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('4oculto')">CONTROL POSTERIOR V.</div></li>
					<div id="controlposteriorOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(4.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(4.22)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(4.33)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('5oculto')">ACTUALIZACIÓN</div></li>
					<div id="actualizacionOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(5.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(5.22)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(5.33)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('6oculto')">EJECUCIÓN</div></li>
					<div id="ejecucionOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(6.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(6.22)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(6.33)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('7oculto')">CONSULTAS PROYECTOS</div></li>
					<div id="consultasOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(7.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(7.22)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(7.33)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu('8oculto')">CONFIGURACIONES</div></li>
					<div id="configuracionesOculto">
						<li class="opciones opcionesli" onclick="ocultarMenu(8.11)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(8.22)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(8.33)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class=""><div class="imgusuario"><div id="nombresesion">JULIAN RODRIGUEZ</div></div></li>
				</ul>
			</div>
		</ul>
	</div>
</nav>
<div class="container-fluid">
	<div class="row">
		<div class="col s12 m2 l2 hide-on-med-and-down">
			<div class="menuizquierda">
				<ul id="ulizquierdo">
					<li class="opciones"><div class="imgul" onclick="ocultarMenu(1.1)">INICIO</div></li>
					<!--
						<div id="inicio">
							<li class="opciones opcionesli" onclick="ocultarMenu(1.1)"><div class="imgul">REGISTRAR</div></li>
							<li class="opciones opcionesli" onclick="ocultarMenu(1.2)"><div class="imgul">ACTUALIZAR</div></li>
							<li class="opciones opcionesli" onclick="ocultarMenu(1.3)"><div class="imgul">BUSCAR</div></li>
						</div>
					-->
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(2)">RADICACIÓN</div></li>
					<div id="radicacion">
						<li class="opciones opcionesli" onclick="ocultarMenu(2.1)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(2.2)"><div class="imgul">LISTA DE CHEQUEO</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(2.3)"><div class="imgul">GENERAR CERTIFICADO</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(3)">VIABILIDAD</div></li>
					<div id="viabilidad">
						<li class="opciones opcionesli" onclick="ocultarMenu(3.1)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(3.2)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(3.3)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(4)">CONTROL POSTERIOR V.</div></li>
					<div id="controlposterior">
						<li class="opciones opcionesli" onclick="ocultarMenu(4.1)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(4.2)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(4.3)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(5)">ACTUALIZACIÓN</div></li>
					<div id="actualizacion">
						<li class="opciones opcionesli" onclick="ocultarMenu(5.1)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(5.2)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(5.3)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(6)">EJECUCIÓN</div></li>
					<div id="ejecucion">
						<li class="opciones opcionesli" onclick="ocultarMenu(6.1)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(6.2)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(6.3)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(7)">CONSULTAS PROYECTOS</div></li>
					<div id="consultas">
						<li class="opciones opcionesli" onclick="ocultarMenu(7.1)"><div class="imgul">REGISTRAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(7.2)"><div class="imgul">ACTUALIZAR</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(7.3)"><div class="imgul">BUSCAR</div></li>
					</div>
					<li class="opciones"><div class="imgul" onclick="mostrarMenu(8)">CONFIGURACIONES</div></li>
					<div id="configuraciones">
						<li class="opciones opcionesli" onclick="ocultarMenu(8.1)"><div class="imgul">USUARIOS</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(8.2)"><div class="imgul">PERMISOS</div></li>
						<li class="opciones opcionesli" onclick="ocultarMenu(8.3)"><div class="imgul">BUSCAR</div></li>
					</div>

					<li class=""><div class="imgusuario"><div id="nombresesion">JULIAN RODRIGUEZ</div></div></li>
				</ul>
			</div>
		</div>

<?php// }
?>