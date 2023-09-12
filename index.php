<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
   <?php include "./inc/head.php"; ?>
</head>
<body>
   <?php 
      // Hacemos comprobaciones.
      if(!isset($_GET['vista']) || $_GET['vista']==""){
         $_GET['vista']="login";
      }
      //is_file Comprueba si un archivo existe en el directorio indicado.
      if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']!="login" && $_GET['vista']!="404"){
      // Seguridad para hacer que el usuario pueda ingresar solo si está logeado.
      // Le cerramos la sesion forzadamente si "no" está definido el id:
         if((!isset($_SESSION['id']) || $_SESSION['id']== "") || 
         (!isset($_SESSION['usuario']) || $_SESSION['usuario']== "")){
            include "./vistas/logout.php";
            exit();
         }
      
      // Componente
      include "./inc/navbar.php";

      include "./vistas/".$_GET['vista'].".php";
      // script responsive pantalla móviles
      include "./inc/script.php";

      }else {
         if($_GET['vista']=="login"){
            include "./vistas/login.php";
         }else{
            include "./vistas/404.php";
         }
      }

   ?>
</body>
</html>