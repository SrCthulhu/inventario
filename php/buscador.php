<?php
	$modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);
    // Hacemos que los $modulos tenga una lista de cada dropdown que tiene la web para hacer
    // la búsqueda en cada sección.
	$modulos=["usuario","categoria","producto"];

	if(in_array($modulo_buscador, $modulos)){
		
        // Cuando estén definidos los módulos va a redireccionar a estas vistas.
		$modulos_url=[
			"usuario"=>"user_search",   
			"categoria"=>"category_search",
			"producto"=>"product_search"
		];
        // Acá sobreescribimos la variable para darle un indice sea user_search, category o product 
        // de lo contrario tendría los 3 y daria error.

		$modulos_url=$modulos_url[$modulo_buscador]; 

        // Acá sobreescribimos la variable para concatenar la variable de sesión cada vez que sea necesario
        // en cada sección de manera correspondiente a usuario, categoria o producto.

		$modulo_buscador="busqueda_".$modulo_buscador;


		# Iniciar busqueda #
		if(isset($_POST['txt_buscador'])){

			$txt=limpiar_cadena($_POST['txt_buscador']);

			if($txt==""){
				echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                Introduce el termino de busqueda
		            </div>
		        ';
			}else{
				if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$txt)){
			        echo '
			            <div class="notification is-danger is-light">
			                <strong>¡Ocurrio un error inesperado!</strong><br>
			                El termino de busqueda no coincide con el formato solicitado
			            </div>
			        ';
			    }else{
					// Modificamos la variable de sesión y recargamos la página.
			    	$_SESSION[$modulo_buscador]=$txt;
			    	header("Location: index.php?vista=$modulos_url",true,303); 
 					exit();  
			    }
			}
		}


		# Eliminar busqueda #
		if(isset($_POST['eliminar_buscador'])){
			unset($_SESSION[$modulo_buscador]);        //eliminamos el valor de la variable de sesión y redireccionamos
			header("Location: index.php?vista=$modulos_url",true,303); 
 			exit();
		}

	}else{
		echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos procesar la peticion
            </div>
        ';
	}