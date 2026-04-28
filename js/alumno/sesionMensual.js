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