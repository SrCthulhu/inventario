<?php
    session_destroy();

    if(headers_sent()){  //comprobamos si enviamos un encabezado que devuelve booleano.
		echo "<script> window.location.href='index.php?vista=login'; </script>"; //si es false
	}else{
		header("Location: index.php?vista=login"); //si es true redirecciona al login
	}