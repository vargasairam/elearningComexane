console.log("registroSesion.js");

const sesion = document.getElementById("sesion");

document.addEventListener("DOMContentLoaded", function() {
    getSesiones();
});

function getSesiones() { 
    let url = `${BASE_URL}/controller/catalogos.php?accion=getSesiones`;
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            if(response.status){
                //console.log(response.data);
                let option = document.createElement("option");
                option.value = "";
                option.textContent = "Selecciona una sesión";
                sesion.appendChild(option);
                let data = response.data;
                data.forEach(element => {
                    option.value = element.id;
                    option.textContent = element.conferencia;
                    sesion.appendChild(option);
                });
            } else{
                let option = document.createElement("option");
                option.value = "";
                option.textContent = "No hay sesiones disponibles";
                sesion.appendChild(option);
            }
        }
    });
}