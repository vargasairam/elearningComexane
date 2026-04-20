const steps = document.querySelectorAll(".form-step");
const stepIndicators = document.querySelectorAll(".step");
const progressBar = document.getElementById("progressBar");

const btnNext = document.querySelector(".next");
const btnPrev = document.querySelector(".prev");
const btnSubmit = document.querySelector(".enviar");

let currentStep = 0;
let currentStepCopia = 0;

let checkAlergias = false;
let preferencias = {};
let preferenciasCompletado = false;

let checkAlergiasSelected = '';
let checkAlergiasOtros = false;

let condiciones = 0;




// botón siguiente
btnNext.addEventListener("click", () => {

    if (currentStep < steps.length - 1) {
        currentStepCopia = currentStep;
        currentStep++;
        updateSteps();
    }

});


// botón anterior
btnPrev.addEventListener("click", () => {

    if (currentStep > 0) {
        currentStepCopia = currentStep;
        currentStep--;
        updateSteps();
    }

});


function updateSteps() {
    if (comprobarInputs()) {
        PantallaTabs()
        currentStepCopia = currentStep;
        // mostrar step actual
        steps.forEach((step, i) => {
            step.classList.toggle("active", i === currentStep);
        });

        // indicador superior
        stepIndicators.forEach((step, i) => {
            step.classList.toggle("active", i <= currentStep);
        });

        // barra progreso
        let percent = ((currentStep + 1) / steps.length) * 100;
        progressBar.style.width = percent + "%";

        // controlar botones
        btnPrev.classList.toggle("d-none", currentStep === 0);
        btnNext.classList.toggle("d-none", currentStep === steps.length - 1);
        btnSubmit.classList.toggle("d-none", currentStep !== steps.length - 1);

    } else {
        currentStep = currentStepCopia;
    }
}

const passwordInput = document.getElementById("Password");

passwordInput.addEventListener("input", function(){

    let value = passwordInput.value;

    validarRegla(value.length >= 8, "rule-length");
    validarRegla(/[A-Z]/.test(value), "rule-upper");
    validarRegla(/[a-z]/.test(value), "rule-lower");
    validarRegla(/[0-9]/.test(value), "rule-number");

});

function validarRegla(condicion, id){

    const elemento = document.getElementById(id);

    if(condicion){
        condiciones++;
        elemento.classList.remove("text-danger");
        elemento.classList.add("text-success");
    }else{
        condiciones--;
        elemento.classList.remove("text-success");
        elemento.classList.add("text-danger");
    }

}

function validarPassword(password){

    const length = password.length >= 8;
    const upper = /[A-Z]/.test(password);
    const lower = /[a-z]/.test(password);
    const number = /[0-9]/.test(password);

    return length && upper && lower && number;

}

function comprobarInputs() {
    console.log(currentStep);
    switch (currentStep) {
        case 1:
            return comprobarStep1();
        break;
        case 2:
            return comprobarStep2();
        break;
        case 3:
            return comprobarStep3();
         break;
        case 4:
            return comprobarStep4();
        break;
    }
    return true;
}

function PantallaTabs() {
    if (tabPantalla) {
        switch (currentStep) {
            case 0:
                document.getElementById('tabCuenta').classList.remove("d-none");
                document.getElementById('tabDatos').classList.add("d-none");
                //document.getElementById('tabProfesion').classList.add("d-none");
                document.getElementById('tabUbicacion').classList.add("d-none");
                //document.getElementById('tabPreferencia').classList.add("d-none");
            break;
            case 1:
                document.getElementById('tabCuenta').classList.add("d-none");
                document.getElementById('tabDatos').classList.remove("d-none");
                //document.getElementById('tabProfesion').classList.add("d-none");
                document.getElementById('tabUbicacion').classList.add("d-none");
                //document.getElementById('tabPreferencia').classList.add("d-none");
            break;
            case 2:
                document.getElementById('tabCuenta').classList.add("d-none");
                document.getElementById('tabDatos').classList.add("d-none");
                //document.getElementById('tabProfesion').classList.remove("d-none");
                document.getElementById('tabUbicacion').classList.add("d-none");
                //document.getElementById('tabPreferencia').classList.add("d-none");
            break;
            case 3:
                document.getElementById('tabCuenta').classList.add("d-none");
                document.getElementById('tabDatos').classList.add("d-none");
                //document.getElementById('tabProfesion').classList.add("d-none");
                document.getElementById('tabUbicacion').classList.remove("d-none");
                //document.getElementById('tabPreferencia').classList.add("d-none");
            break;
            case 4:
                document.getElementById('tabCuenta').classList.add("d-none");
                document.getElementById('tabDatos').classList.add("d-none");
                //document.getElementById('tabProfesion').classList.add("d-none");
                document.getElementById('tabUbicacion').classList.add("d-none");
                //document.getElementById('tabPreferencia').classList.remove("d-none");
            break;
        }
    } else {
        document.getElementById('tabCuenta').classList.remove("d-none");
        document.getElementById('tabDatos').classList.remove("d-none");
        //document.getElementById('tabProfesion').classList.remove("d-none");
        document.getElementById('tabUbicacion').classList.remove("d-none");
        //document.getElementById('tabPreferencia').classList.remove("d-none");
    }
}

function comprobarStep1() {
    let pass = document.getElementById('Password').value;
    let ComPass = document.getElementById('PasswordC').value;
    let Correo = document.getElementById('Correo').value;
    let categoria = document.getElementById('Categoria').value;

    if(!validarPassword(pass)){

        mostrarAviso("warning", 'La contraseña no cumple con los requisitos', 3000);
        return false;
    }

    if (!Correo || !pass || !categoria) {
        mostrarAviso("warning", 'Faltan datos por rellenar', 3000);
        return false;
    }

    if (pass != ComPass) {
        mostrarAviso("warning", 'Las contraseñas no coinciden', 3000);
        return false;
    }

    return true;
}
function comprobarStep2() {
    let titulo = document.getElementById('prefijos').value;
    let textTitulo = document.getElementById('prefijo2').value;
    let nombre = document.getElementById('Nombres').value;
    let apellidop = document.getElementById('Apellidop').value;
    let apellidom = document.getElementById('Apellidom').value;
    let celular = document.getElementById('celular').value;
    let curp = document.getElementById('curp').value;

    if (!titulo || !nombre || !apellidop || !apellidom || !celular || !curp) {
        mostrarAviso("warning", 'Faltan datos por rellenar', 3000);
        return false;
    }

    if (titulo == 'OTRO' && !textTitulo) {
        mostrarAviso("warning", 'Las contraseñas no coinciden', 3000);
        return false;
    }

    return true;
}

function comprobarStep3() {
    let rfc = document.getElementById('rfc').value;
    let curp = document.getElementById('curp').value;

    if (!rfc || !curp) {
        mostrarAviso("warning", 'Faltan datos por rellenar', 3000);
        return false;
    }

    return true;
}

function comprobarStep4() {
    let calle = document.getElementById('calle').value;
    let n_interior = document.getElementById('n_interior').value;
    let colonia = document.getElementById('colonia').value;
    let localidad = document.getElementById('localidad').value;
    let municipio = document.getElementById('municipio').value;
    let estado = document.getElementById('Estado').value;
    let cp = document.getElementById('cp').value;
    
    /*if (!calle || !n_interior || !colonia || !localidad || !municipio || !estado || !cp) {
        mostrarAviso("warning", 'Faltan datos por rellenar', 3000);
        return false;
    }*/

    return true;
}

//preguntas
document.querySelectorAll('input[name="accesibilidad"]').forEach(radio => {
    radio.addEventListener('change', function () {

        if (this.value === "si") {
            preferencias['movilidad'] = 1;
            document.getElementById("detalleAccesibilidad").classList.remove("d-none");
            document.getElementById("detalleAccesibilidad").required = true;
        } else {
            preferencias['movilidad'] = 0;
            document.getElementById("detalleAccesibilidad").classList.add("d-none");
            document.getElementById("detalleAccesibilidad").required = false;
        }

    });
});

document.querySelectorAll('input[name="traduccion"]').forEach(radio => {
    radio.addEventListener('change', function () {

        if (this.value === "si") {
            preferencias['traduccion'] = 1;
        } else {
            preferencias['traduccion'] = 0;
        }

    });
});

document.querySelectorAll('input[name="eventos"]').forEach(radio => {
    radio.addEventListener('change', function () {

        if (this.value === "si") {
            preferencias['eventos'] = 1;
        } else {
            preferencias['eventos'] = 0;
        }

    });
});

document.querySelectorAll('input[name="alergia"]').forEach(radio => {
    radio.addEventListener('change', function () {

        if (this.value === "si") {
            checkAlergias = true;
            preferencias['alergia'] = 1;
            document.getElementById("opcionesDieta").classList.remove("d-none");
        } else {
            checkAlergias = false;
            preferencias['alergia'] = 0;
            document.getElementById("opcionesDieta").classList.add("d-none");
        }

    });
});

document.getElementById("otroDieta").addEventListener("change", function () {

    if (this.checked) {
        checkAlergiasOtros = true;
        document.getElementById("dieta_otro").classList.remove("d-none");
        document.getElementById("dieta_otro").required = true;
    } else {
        checkAlergiasOtros = false;
        document.getElementById("dieta_otro").classList.add("d-none");
        document.getElementById("dieta_otro").required = false;
    }

});

document.getElementById("enterado").addEventListener("change", function () {

    preferencias['enterado'] = this.value;

    if (this.value === '6') {
        document.getElementById("otro_medio").classList.remove("d-none");
        document.getElementById("otro_medio").required = true;
    } else {
        document.getElementById("otro_medio").classList.add("d-none");
        document.getElementById("otro_medio").required = false;
    }

});


document.querySelectorAll('input[name="recibo"]').forEach(radio => {
    radio.addEventListener('change', function () {

        if (this.value === "si") {
            preferencias['recibo'] = 1;
            document.getElementById("facturacionBox").classList.remove("d-none");
            // document.getElementById("rfc").required = true;
            // document.getElementById("razon_social").required = true;
            // document.getElementById("correo_factura").required = true;
            // document.getElementById("cp_factura").required = true;
        } else {
            preferencias['recibo'] = 0;
            document.getElementById("facturacionBox").classList.add("d-none");
            document.getElementById("rfc").required = false;
            document.getElementById("razon_social").required = false;
            document.getElementById("correo_factura").required = false;
            document.getElementById("cp_factura").required = false;
        }

    });
});

document.querySelectorAll('input[name="dieta[]"]').forEach(ch => {

    ch.addEventListener("change", () => {
        validarCheckbox();
    });

});

document.getElementById("formModal").addEventListener("submit", function (e) {
    let otrasAlergias = validarCheckbox();
    if (!this.checkValidity() || !otrasAlergias) {
        e.preventDefault(); // evita envío
        this.reportValidity(); // muestra errores del navegador
        return;
    }

    e.preventDefault();
    GuardarInformacionPreferencias()
    console.log(preferencias);
    const modal = bootstrap.Modal.getInstance(document.getElementById("modalCuestionario"));
    modal.hide();


});

function validarCheckbox() {
    let checkboxes = document.querySelectorAll('input[name="dieta[]"]');
    if (checkAlergias) {
        let seleccionado = false;
        let check = [];

        checkboxes.forEach(ch => {
            if (ch.checked) {
                seleccionado = true;
                check.push(ch.value);
            }
        });
        if (checkAlergiasOtros) {
            check.push('99');
        }

        checkSelected = check.join(",");

        if (!seleccionado && !checkAlergiasOtros) {
            document.getElementById("vegetariano").required = true;
            return false;
        }

        document.getElementById("vegetariano").required = false;
    }




    return true;
}

function GuardarInformacionPreferencias() {
    preferenciasCompletado = true;

    if (preferencias['movilidad']) {
        preferencias['razonMovilidad'] = document.getElementById('detalleAccesibilidad').value;
    }

    if (preferencias['enterado'] == '6') {
        preferencias['razonEnterado'] = document.getElementById('otro_medio').value;
    }

    if (preferencias['alergia']) {
        preferencias['idsAlergias'] = checkSelected;
        if (checkAlergiasOtros) {
            preferencias['razonAlergias'] = document.getElementById('dieta_otro').value;
        }
    }

    if (preferencias['recibo']) {
        preferencias['facturacion'] = {
            rfc: document.getElementById('rfc').value,
            razon: document.getElementById('razon_social').value,
            correo: document.getElementById('correo_factura').value,
            cp: document.getElementById('cp_factura').value,
        };
    }
}

