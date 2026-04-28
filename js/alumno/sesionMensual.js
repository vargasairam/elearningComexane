console.log("sesionMensual.js");

$(document).on('submit', '#questionForm', function(e) {
    e.preventDefault();
    btn_submit = document.getElementById("btn_submit");
    btn_submit.disabled = true;
    let pregunta = $("#question").val();
    if(pregunta == "") {
        mostrarAviso('warning', "Por favor ingrese una pregunta");
        return;
    }

    let url = `${BASE_URL}controller/sesiones.php?accion=saveQuestion`;
    let FORMDATA = new FormData($(this)[0]);

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        console.log(data);
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            $("#question").val("");   
            btn_submit.disabled = false;         
        } else {
            mostrarAviso(data.status, data.msg);
            btn_submit.disabled = false;
        }
    })
    .catch(err => {
        btn_submit.disabled = false;
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});

//GUARDAR PROGRESO DE LA SESION
const iframe = document.getElementById('video-v');
const player = new Vimeo.Player(iframe);

let avance = 0;
let ultimoMinuto = 0;

// SOLO una vez
player.on('timeupdate', function(data) {
    const segundosActuales = Math.floor(data.seconds);

    if (segundosActuales > avance) {
        avance = segundosActuales;

        // cada minuto exacto
        if (avance % 60 === 0 && avance !== ultimoMinuto) {
            ultimoMinuto = avance;
            sumarMinuto();
        }
    }
});

/*player.on('ended', function() {
    //console.log("video terminado");
    marcarVideo();
});*/

// opcional: detectar play
player.on('play', function() {
    console.log('Reproduciendo video ONDEMAND');
});

function sumarMinuto () {
    console.log("sumar minuto");
    $.ajax({
        url: 'controller/sesiones.php?accion=addminutoSesion',
        type: 'POST',
        dataType: 'json',
        data: {
            //accion: "addminutoVideo", 
            sesion_id: sesionId, 
            usuario_id: user
        },
    }).done(function(response) {
        console.log(response);
    });
}

function marcarVideo () {
    console.log("video terminado");
    $.ajax({
        url: 'controller/sesiones.php?accion=endedSesion',
        type: 'POST',
        dataType: 'json',
        data: {
            sesion_id: sesionId, 
            usuario_id: user
        }
    })
    .done(function(response) {
        console.log("SUCCESS", response);
    })
    .fail(function(error) {
        console.error("ERROR AJAX", error);
    });
}



