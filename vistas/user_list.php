<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">  
    <?php
        require_once "./php/main.php"; //requerimos el archivo con la db

        # Eliminar usuario #
        if(isset($_GET['user_id_del'])){ 
            require_once "./php/usuario_eliminar.php";
        }
 
        if(!isset($_GET['page'])){          //Si la variable page no está definida le damos el valor de 1.
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];    //convertimos la variable en un número entero.
            if($pagina<=1){                 //si tiene un valor negativo menor a uno se le asigna siempre el valor uno evitando errores que el numero de pag muestre por ejemplo -15.
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=user_list&page=";
        $registros=15;                   //con registros limitamos la cantidad de tablas mostradas por número de página a 15 máx.
        $busqueda="";

        # Paginador usuario #
        require_once "./php/usuario_lista.php";
    ?>
</div>