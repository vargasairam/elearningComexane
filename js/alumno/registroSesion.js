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
            let option = document.createElement("option");
            if(response.status){
                console.log(response.data);

                let optionDefault = document.createElement("option");
                optionDefault.value = "";
                optionDefault.textContent = "Selecciona una sesión";
                sesion.appendChild(optionDefault);

                let data = response.data;

                data.forEach(element => {
                    let option = document.createElement("option"); // 👈 nuevo cada vez
                    option.value = element.id;
                    option.textContent = element.conferencia;
                    sesion.appendChild(option);
                });
            } else {
                option.value = "";
                option.textContent = "No hay sesiones disponibles";
                sesion.appendChild(option);
            }
        }
    });
}