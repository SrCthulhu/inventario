<?php
// Conexión a db.
    function conexion(){
        $pdo= new PDO('mysql:host=localhost;dbname=inventario','root','');
        return $pdo;
    }
    function verificar_datos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/", $cadena)){
            return false;
        }else{
            return true;
        }
    }
// Limpiar cadenas de texto
    function limpiar_cadena($cadena){
        $cadena=trim($cadena); //trim limpia espacios en blanco.
        $cadena=stripcslashes($cadena); //limpia los slashes.
        $cadena=str_ireplace("<script>","",$cadena); //Evitamos inyeccion de sql y ataques xss.
        $cadena=str_ireplace("</script>", "", $cadena);
		$cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena);
		$cadena=str_ireplace("SELECT * FROM", "", $cadena);
		$cadena=str_ireplace("DELETE FROM", "", $cadena);
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena);
		$cadena=str_ireplace("DROP DATABASE", "", $cadena);
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena);
		$cadena=str_ireplace("?>", "", $cadena);
		$cadena=str_ireplace("--", "", $cadena);
		$cadena=str_ireplace("^", "", $cadena);
		$cadena=str_ireplace("<", "", $cadena);
		$cadena=str_ireplace("[", "", $cadena);
		$cadena=str_ireplace("]", "", $cadena);
		$cadena=str_ireplace("==", "", $cadena);
		$cadena=str_ireplace(";", "", $cadena);
		$cadena=str_ireplace("::", "", $cadena);
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		return $cadena;
    }

    function renombrar_fotos($nombre){
		$nombre=str_ireplace(" ", "_", $nombre);
		$nombre=str_ireplace("/", "_", $nombre);
		$nombre=str_ireplace("#", "_", $nombre);
		$nombre=str_ireplace("-", "_", $nombre);
		$nombre=str_ireplace("$", "_", $nombre);
		$nombre=str_ireplace(".", "_", $nombre);
		$nombre=str_ireplace(",", "_", $nombre);
		$nombre=$nombre."_".rand(0,100); // evitamos conflictos entre los nombres de las fotos con num alatorio.
		return $nombre;
	}
// Funcion paginador de tablas 
	function paginador_tablas($pagina,$Npaginas,$url,$botones){  //pagina actual, Npaginas= numero de páginas que tendrá.
                                                                 //definimos el html de la paginacion de bulma.   
		$tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		if($pagina<=1){                                        //desabilitamos botón en la pag 1.
			$tabla.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a> 
			<ul class="pagination-list">';
		}else{                                                 //Habilitamos el botón para regresar restando una página.
			$tabla.='
			<a class="pagination-previous" href="'.$url.($pagina-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}
        // Contador de iteraciones.
		$ci=0;
		for($i=$pagina; $i<=$Npaginas; $i++){
			if($ci>=$botones){  //controlamos la cantidad de botones creados para no sobrecargar el paginador
				break;
			}
			if($pagina==$i){
				$tabla.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$tabla.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}

		if($pagina==$Npaginas){  //verificamos si estamos en la última página para deshabilitar el botón de siguiente
			$tabla.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Siguiente</a>
			';
		}else{    //si aún quedan páginas aumentamos el valor para pasar a la página siguiente. La url la concatenamos para que nos lleve a la última pagina.
			$tabla.='
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($pagina+1).'" >Siguiente</a> 
			';
		}

		$tabla.='</nav>';
		return $tabla;
	}

