const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    e.preventDefault(); //es para prevenir que redireccione la misma página al ejecutar la función con el formulario cargado.
    //lanzamos alert de pregunta al usuario. devuelve booleano true o false dependiendo lo elegido
    let enviar = confirm("¿Quieres enviar el formulario?");
    if (enviar == true) {
        //data tendrá todos los datos del formulario. en caso de que el alert devuelva true.
        // seleccionamos con getattribute los mismos atributos que tiene el formulario, el metodo post usado en este caso
        // y la acción a la ruta de carga.php.

        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");  //url donde enviamos los datos
        let encabezados = new Headers();
        let config = {
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };
        fetch(action, config) //hacemos fetch con la ruta elegida y con la configuración realizada.
            .then(respuesta => respuesta.text()) //esperamos para recibir una promesa y convertimos la respuesta en texto plano.
            .then(respuesta => {
                let contenedor = document.querySelector(".form-rest"); //seleccionamos un elemento html que es un <div> con la clase form-rest
                contenedor.innerHTML = respuesta; //le insertamos con innerHTML la respuesta al contenedor.
            });
    }
}
formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviar_formulario_ajax);
});



/*CORS (Cross-Origin Resource Sharing) es un mecanismo o
política de seguridad que permite controlar las peticiones HTTP
asíncronas que se pueden realizar desde un navegador a un servidor con un dominio
diferente de la página cargada originalmente. Este tipo de peticiones se llaman peticiones 
de origen cruzado (cross-origin) */