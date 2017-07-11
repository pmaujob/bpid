<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login BPID</title>
</head>
<style type="text/css">
	body
	{
		background-color: #E5E6E7;
	}
	#contenedor
	{
		width: 100%;
		height: 800px;
		/*background-color: red;*/
	}
	#izquierda
	{
		width: 50%;
		height: 799px;
		/*background-color: blue;*/
		float: left;
	}
	#derecha
	{
		width: 50%;
		height: 799px;
		/*background-color: yellow;*/
		float: left;
	}
	#imglogin
	{
		/*background-color: #0CF64E;*/
		width: 500px;
		height:500px;
		margin-top: 150px;
		margin-left: 100px;
		background-image: url(vistas/img/img_login.png);background-repeat: no-repeat;
		background-size: contain;
	}
	#imglogo
	{
		/*background-color: #0CF64E;*/
		width: 500px;
		height:500px;
		margin-top: 150px;
		margin-left: 100px;
		background-image: url(vistas/img/img_logo.png);background-repeat: no-repeat;
		background-size: contain;
	}
	#botones
	{	position: absolute;
		margin-top: 155px;
		margin-left: 310px;
		color: white;
	}
	#btnenviar
	{
		border-style: none;
		border-radius: 4px;
		width: 85px;
		height: 20px;
		margin-left: 88px;
	}
	.btnslogin
	{
		border-radius: 5px;
	}

</style>
<body>
	<div id="contenedor">
		<div id="izquierda">
			<div id="imglogin">
				<div id="botones">
				<form method="post" action="controlador/c_login.php">
					<label>Usuario</label><br>
					<input class="btnslogin" type="text" name="txt_correo" value="julianrodri11@gmail.com"><br>
					<label>Contraseña</label><br>
					<input class="btnslogin" type="password" name="txt_contrasena" value="123"><br><br>
					<input type="submit" id="btnenviar" value="Iniciar sesión">
				</form>
				</div>
			</div>

		</div>

		<div id="derecha">
			<div id="imglogo"></div>

		</div>

	</div>

	</body>
</html>
