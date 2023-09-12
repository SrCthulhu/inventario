<?php

	/*== Almacenando datos ==*/
    $user_id_del=limpiar_cadena($_GET['user_id_del']);

    /*== Verificando que exista el usuario seleccionado en la lista ==*/
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'");

    // rowCount nos indica cuantos registros hemos seleccionado con esta consulta
    // si existe entra en el if.

    if($check_usuario->rowCount()==1){  
        
    	$check_productos=conexion(); // Verificamos si el usuario tiene productos, si ha registrado más de un producto no podrá ser eliminado.
    	$check_productos=$check_productos->query("SELECT usuario_id FROM producto WHERE usuario_id='$user_id_del' LIMIT 1");

    	if($check_productos->rowCount()<=0){ // Verificamos si no tiene productos pues lo eliminamos.
    		
	    	$eliminar_usuario=conexion();    // Usamos prepare en vez de "query" para evitar la inyección de sql. Usamos marcador :id
	    	$eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id");
            
	    	$eliminar_usuario->execute([":id"=>$user_id_del]); // Acá lo ejecutamos. Asignando el valor de $user_id_del

	    	if($eliminar_usuario->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light"> 
		                <strong>¡USUARIO ELIMINADO!</strong><br>
		                Los datos del usuario se eliminaron con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar el usuario, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_usuario=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar el usuario ya que tiene productos registrados por el
	            </div>
	        ';
    	}
    	$check_productos=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO que intenta eliminar no existe
            </div>
        ';
    }
    $check_usuario=null;