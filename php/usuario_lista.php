<?php
    // Acá comenzamos la búsqueda en la db, hacemos un if con ? si la página no viene definida vamos a contar
    // desde el indice 0 de la db
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0; 
	$tabla="";

	if(isset($busqueda) && $busqueda!=""){   //si la busqueda está definida y es diferente de vacío hacemos la consulta

		$consulta_datos="SELECT * FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND 
		(usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR 
		usuario_usuario LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%')) 
		ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND 
		(usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usuario 
		LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%'))";

	}else{

		$consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' ORDER BY 
		usuario_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."'";
		
	}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll(); //Una vez que tenemos los datos hacemos un array de todos los registros

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn(); // Devuelve una columna de los resultados
	// Calculamos el número de páginas, ceil es una función que redondea al entero próximo. 
	// este resultado devuelve un número decimal de 2.5 por eso es necesario redondear a 3 tablas por página. 
	$Npaginas =ceil($total/$registros); 

	$tabla.='
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

	// Si el total de registros es mayor o igual a 1 y la pagina es menor o 
	// igual al número de paginas totales mostramos el registro sino mostramos
	// un texto de que no hay registros en el sistema. ó un botón para recargar
	// el resultado que nos lleva a la pag número 1.

	if($total>=1 && $pagina<=$Npaginas){ 
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['usuario_nombre'].'</td>
                    <td>'.$rows['usuario_apellido'].'</td>
                    <td>'.$rows['usuario_usuario'].'</td>
                    <td>'.$rows['usuario_email'].'</td>
                    <td>                              
                        <a href="index.php?vista=user_update&user_id_up='.$rows['usuario_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$rows['usuario_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}