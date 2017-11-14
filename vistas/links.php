<?php
@session_start();

$raizHtml = $_SESSION['raizHtml'];
?>

<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href=<?php echo $raizHtml . '/vistas/css/materialize.min.css' ?>  media="screen,projection"/>

<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="theme-color" content="#F46842"/>
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="#2AAD0C"/>

<!--Import jQuery before materialize.js-->
<!--script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script-->
<script type="text/javascript" src=<?php echo $raizHtml . '/vistas/js/jquery-2.1.1.min.js' ?>></script>
<script type="text/javascript" src=<?php echo $raizHtml . '/vistas/js/jquery-ui.js' ?>></script>
<script type="text/javascript" src=<?php echo $raizHtml . '/vistas/js/materialize.min.js' ?>></script>
<script type="text/javascript" src=<?php echo $raizHtml . '/vistas/js/menu.js' ?>></script>

<link rel="stylesheet" type="text/css" href=<?php echo $raizHtml . '/vistas/css/menu.css' ?>>
<link rel="stylesheet" type="text/css" href=<?php echo $raizHtml . '/vistas/css/cssbpid/styles.css' ?>>
<link rel="stylesheet" type="text/css" href=<?php echo $raizHtml . '/vistas/css/jquery-ui.css' ?>>
<link rel="stylesheet" type="text/css" href=<?php echo $raizHtml . '/vistas/css/theme.css' ?>>
<link rel="stylesheet" type="text/css" href=<?php echo $raizHtml . '/vistas/css/cambiosgenerales.css' ?>>

<link rel="shortcut icon" type="image/x-icon" href=<?php echo $raizHtml . '/vistas/img/mod.ico' ?>>


