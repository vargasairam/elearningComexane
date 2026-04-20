document.addEventListener("DOMContentLoaded", function(){
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('response');

    if(urlParams.has('existente')){
        mostrarAviso("warning",'El correo ya se encuentra registrado para esa categoria');
    }else if(urlParams.has('exito')){
        mostrarAviso("success",'El correo ya guardo correctamente');
    }else if(urlParams.has('error')){
        mostrarAviso("error",'Ocurrio un error al insertar el correo, intentelo nuevamente mas tarde.');
    }
});


function mostrarAviso(clase, mensaje, timeOut = 3500) {
		var message = mensaje;
		var title = "Mensaje";
		var type = clase;
		toastr[type](message, title, {
			positionClass: "toast-top-right",
			closeButton: false,
			progressBar: true,
			newestOnTop: true,
			timeOut: timeOut,
			debug: false,
			onclick: null
		});
	}