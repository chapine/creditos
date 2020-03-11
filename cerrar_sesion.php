<?php
	session_start();
	session_destroy();

	if($_SESSION["id_usuario"]=='' OR $_SESSION['tipo_usuario']=='' OR $_SESSION['nombre']=='' OR $_SESSION['usuario']=='' OR $_COOKIE['mensaje']==''){
		header("Location: index.php");
	}

	$mensaje = $_COOKIE['mensaje'];
?>
<!DOCTYPE html>
<html lang="es">
     <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Error" />
	<meta http-equiv="Refresh" content="15;url=index.php">
	<title>Sesión Cerrada</title>
        <style>
            ::-moz-selection {background: #b3d4fc; text-shadow: none;}
            ::selection {background: #b3d4fc; text-shadow: none;}
            html {padding: 30px 10px; font-size: 16px; line-height: 1.4; color: #737373; background: #f0f0f0;
                -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}
            html,
            input {font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;}
            body {max-width:700px; _width: 700px; padding: 30px 20px 50px; border: 1px solid #b3b3b3;
                border-radius: 4px;margin: 0 auto; box-shadow: 0 1px 10px #a7a7a7, inset 0 1px 0 #fff;
                background: #fcfcfc;}
            h1 {margin: 0 10px; font-size: 50px; text-align: center;}
            h1 span {color: #bbb;}
            h2 {color: #D35780;margin: 0 10px;font-size: 35px;text-align: center;}
            h2 span {color: #bbb;font-size: 80px;}
            h3 {margin: 1.5em 0 0.5em;}
            p {margin: 1em 0;}
            ul {padding: 0 0 0 40px;margin: 1em 0;}
            .container {max-width: 100%; _width: 100%; margin: 0 auto;}
            input::-moz-focus-inner {padding: 0;border: 0;}
			
			.a_demo_one {
				background-color:#3bb3e0;
				padding:10px;
				position:relative;
				font-family: 'Open Sans', sans-serif;
				font-size:15px;
				text-decoration:none;
				color:#fff;
				border: solid 1px #186f8f;
				background-image: linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
				background-image: -o-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
				background-image: -moz-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
				background-image: -webkit-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
				background-image: -ms-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
				background-image: -webkit-gradient(
				linear,
				left bottom,
				left top,
				color-stop(0, rgb(44,160,202)),
				color-stop(1, rgb(62,184,229))
				);
				-webkit-box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
				-moz-box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
				box-shadow: inset 0px 1px 0px #7fd2f1, 0px 1px 0px #fff;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				-o-border-radius: 5px;
				border-radius: 5px;
			}

			.a_demo_one::before {
				background-color:#ccd0d5;
				content:"";
				display:block;
				position:absolute;
				width:100%;
				height:100%;
				padding:8px;
				left:-8px;
				top:-8px;
				z-index:-1;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				-o-border-radius: 5px;
				border-radius: 5px;
				-webkit-box-shadow: inset 0px 1px 1px #909193, 0px 1px 0px #fff;
				-moz-box-shadow: inset 0px 1px 1px #909193, 0px 1px 0px #fff;
				-o-box-shadow: inset 0px 1px 1px #909193, 0px 1px 0px #fff;
				box-shadow: inset 0px 1px 1px #909193, 0px 1px 0px #fff;
			}

			.a_demo_one:active {
				padding-bottom:9px;
				padding-left:10px;
				padding-right:10px;
				padding-top:11px;
				top:1px;
				background-image: linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
				background-image: -o-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
				background-image: -moz-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
				background-image: -webkit-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
				background-image: -ms-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
				background-image: -webkit-gradient(
				linear,
				left bottom,
				left top,
				color-stop(0, rgb(62,184,229)),
				color-stop(1, rgb(44,160,202))
				);
			}
        </style>
    </head>
    <body>
        <div class="container">
            <h2><span>401</span> Sesión finalizada</h2>
            <p>¡Vaya! Algo salió mal.<br /><br /><?php echo $mensaje; ?></p>
            <br>
            <p><a href="#" onClick="javascript:location.href='index.php'" class="a_demo_one"> Iniciar sesión </a></p>
        </div>
    </body>
</html>