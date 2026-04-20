console.log("Hola");
let InformacionUsuario = {};
let otraCategoria = false;
let tabPantalla = false;



document.addEventListener("DOMContentLoaded", function (){
    init();
    // Ejecuta al cargar la página
    handleScreenChange(mediaQuery);

    //EVENTO PARA SOLO PERMITIR NUMEROS EN EL INPUT (para el input del telefono)
    const inputTelefono = document.getElementById('celular');
    inputTelefono.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 15); // solo números
    });

    const inputPais = document.getElementById('Paises');
    GetEstadosByIdPais(156)
    /*inputPais.addEventListener('change',function(e){
        GetEstadosByIdPais(this.value);
        console.log(this)
        SetExtensionBandera(this)
    });*/

    const inputCategoria = document.getElementById('Categoria');
    inputCategoria.addEventListener('change',function(e){
        if(this.value=='5'){
            otroCategoria()
            otraCategoria = true;
        }
        
    });

    const enviar = document.getElementById('enviar');
    enviar.addEventListener('click',function(e){
        GetInformacionRegistro()
        /*if(preferenciasCompletado){
            GetInformacionRegistro()
        }else{
            mostrarAviso("warning",'Completa el cuestionario para continuar',3000);
        }*/
    });

    // const selectCategoria = document.getElementById('Categoria');
    // selectCategoria.addEventListener('change',function(e){
    //     document.getElementById('codigo').value = '';
    //     console.log(this.value);
    //     if(this.value==4){
    //         console.log('entro');
    //         document.getElementById('divCodigo').classList.remove('d-none');
    //     }else{
    //         console.log('no entro');
    //         document.getElementById('divCodigo').classList.add('d-none');
    //     }
        
    // });

    const Daviso = document.getElementById('Daviso');
    const DCancelacion = document.getElementById('DCancelacion');

    const Eaviso = document.getElementById('Eaviso');
    const ECancelacion = document.getElementById('ECancelacion');

    const BtnRegistrarDoctor = document.getElementById('registrarDoctor');
    const BtnRegistrarEnfermera = document.getElementById('registrarEnfermera');

    Daviso.addEventListener('change', validarCheckbox);
    DCancelacion.addEventListener('change', validarCheckbox);

    Eaviso.addEventListener('change', validarCheckboxEnfermera);
    ECancelacion.addEventListener('change', validarCheckboxEnfermera);

    //BTN ENVIAR
    BtnRegistrarDoctor.addEventListener('click',function(e){
        EnviarDatos()
        
    });

    BtnRegistrarEnfermera.addEventListener('click',function(e){
        EnviarDatos()
        
    });

    function validarCheckbox() {
        if (Daviso.checked && DCancelacion.checked) {
            console.log('si');
            BtnRegistrarDoctor.disabled = false;
        } else {
            console.log('no');
            BtnRegistrarDoctor.disabled = true;
        }
        
    }

    function validarCheckboxEnfermera() {
        if (Eaviso.checked && ECancelacion.checked) {
            console.log('si');
            BtnRegistrarEnfermera.disabled = false;
        } else {
            console.log('no');
            BtnRegistrarEnfermera.disabled = true;
        }
    }
})




async function GetCatalogosRegistros() {
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetCatalogos", {
            method: "GET"
        });
        let response = await res.json();
        console.log(response)
        
        if(response.status){
            setCategorias(response.data.categorias)
            //setPaises(response.data.paises)
            //setPrefijos(response.data.prefijos)
            //setPaises(response.data.paises)
            //setEdades(response.data.edades);
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}

async function GetEstadosByIdPais(id_pais) {
    let datos = {
        pais: id_pais
    }
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetEstados", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ datos })
        });
        let response = await res.json();
        console.log(response)
        
        if(response.status){
            setEstados(response.data.estados);
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}

function setCategorias(data){
    let select = document.getElementById('Categoria');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_categoria;
        option.textContent = element.nombre_categoria;
        select.appendChild(option);
    });
}

function setPrefijos(data){
    let select = document.getElementById('prefijos');
    console.log(data)
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.prefijo;
        option.textContent = element.prefijo;
        select.appendChild(option);
    });
}
function setPaises(data){
    let select = document.getElementById('Paises');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_pais;
        option.textContent = element.pais;
        option.dataset.iso = element.iso2;
        option.dataset.lada = element.extension;

        if(element.id_pais == 156){
            option.selected = true;
            option.textContent = element.pais;
            option.dataset.iso = element.iso2;
            option.dataset.lada = element.extension;
            GetEstadosByIdPais(element.id_pais)
        }
        select.appendChild(option);
    });
}

function setEstados(data){
    document.getElementById("Estado").innerHTML = "";
    let select = document.getElementById('Estado');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.estado.toUpperCase();
        option.textContent = element.estado.toUpperCase();
        select.appendChild(option);
    });
}

function setEdades(data){
    // document.getElementById("edad").innerHTML = "";
    let select = document.getElementById('edad');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id;
        option.textContent = element.edad;
        select.appendChild(option);
    });
}

function SetExtensionBandera(pais){
    let optionSeleccionado = pais.options[pais.selectedIndex];

    let iso = optionSeleccionado.dataset.iso;
    let lada = optionSeleccionado.dataset.lada;

    let banderaPais = document.getElementById('banderaPais');
    let codigoPais = document.getElementById('codigoPais');
    banderaPais.src = 'https://flagcdn.com/24x18/'+iso+'.png'
    codigoPais.textContent = lada;

}

function init(){
    GetCatalogosRegistros()
}

function otroPrefijo(){
    document.getElementById("prefijodiv").classList.add('d-none');
    document.getElementById("prefijo2div").classList.remove('d-none');
}
function otroCategoria(){
    document.getElementById("categoriaDivSelect").classList.add('d-none');
    document.getElementById("categoriaDiv").classList.remove('d-none');
}

function GetInformacionRegistro(){
    InformacionCuenta()
    InformacionDatos()
    InformacionFiscal()
    InformacionDireccion()
    //InformacionProfesional()
    //InformacionUsuario['preferencia'] = preferencias;
    console.log(InformacionUsuario);
    EnviarDatos();

    /*if(InformacionUsuario['cuenta']!='4'){
        var modal = new bootstrap.Modal(document.getElementById('ModalDoctor'));
        modal.show();
    }else{
        var modal = new bootstrap.Modal(document.getElementById('ModalEnfermera'));
        modal.show();
    }*/

}

function InformacionCuenta(){
    InformacionUsuario['cuenta'] = {
        correo:document.getElementById('Correo').value,
        pass:document.getElementById('Password').value,
        categoria:document.getElementById('Categoria').value
    }

    if(document.getElementById('prefijos').value == '5'){
        InformacionUsuario['cuenta']['textCategoria'] = document.getElementById('categoria2').value
    }
}

function InformacionDatos(){
    InformacionUsuario['datos'] = {
        prefijo:document.getElementById('prefijos').value,
        nombre:document.getElementById('Nombres').value,
        apellidop:document.getElementById('Apellidop').value,
        apellidom:document.getElementById('Apellidom').value,
        f_nacimiento:document.getElementById('f_nacimiento').value,
        celular:document.getElementById('celular').value,
        //particular1:document.getElementById('particular1').value,
        //particular2:document.getElementById('particular2').value,
        n_constancia:document.getElementById('nombreConstancia').value
    }

    if(document.getElementById('prefijos').value == 'OTRO'){
        InformacionUsuario['datos']['titulo'] = document.getElementById('prefijo2').value
    }

}

function InformacionFiscal(){
    InformacionUsuario['fiscal'] = {
        //rfc:document.getElementById('rfc').value,
        curp:document.getElementById('curp').value,
    }
}

function InformacionDireccion(){
    InformacionUsuario['ubicacion'] = {
        calle:document.getElementById('calle').value,
        interior:document.getElementById('n_interior').value,
        exterior:document.getElementById('n_exterior').value,
        colonia:document.getElementById('colonia').value,
        localidad:document.getElementById('localidad').value,
        estado:document.getElementById('Estado').value,
        municipio:document.getElementById('municipio').value,
        cp:document.getElementById('cp').value
    }
}

function InformacionProfesional(){
    InformacionUsuario['profesional'] = {
        ced_prof:document.getElementById('ced_prof').value,
        ced_esp:document.getElementById('ced_esp').value,
        pregrado:document.getElementById('pregrado').value
    }
}

//pantalla
const mediaQuery = window.matchMedia("(max-width: 680px)");

function handleScreenChange(e) {
    if(e.matches){
        tabPantalla = true;
        console.log('sssss')
        PantallaTabs()
    } else {
        tabPantalla = false;
        console.log('2222')
        PantallaTabs()
    }
}

// Escucha cambios de tamaño
mediaQuery.addEventListener("change", handleScreenChange);
correo_input = document.getElementById('Correo');

correo_input.addEventListener('blur', function() {
    let correo_busq = this.value;
    $.ajax({
        url : "controller/registro.php?accion=correoSocio&correo="+correo_busq,
        type: "GET",
        success: function(data){
            let respuesta = JSON.parse(data);

            if(respuesta.success){
                console.log(respuesta.data);
                mostrarAviso("warning",'Ya tienes una cuenta como socio, puedes iniciar sesión con las mismas credenciales.',3000);
                /*$('#Categoria').val(respuesta.data[0].id_categoria);
                $('#Nombres').val(respuesta.data[0].nombre);
                $('#Apellidop').val(respuesta.data[0].apellidop);
                $('#Apellidom').val(respuesta.data[0].apellidom);
                $('#celular').val(respuesta.data[0].celular);
                $('#nombreConstancia').val(respuesta.data[0].nombreconstancia);
                $('#prefijos').val(respuesta.data[0].prefijotxt);
                $('#rfc').val(respuesta.data[0].rfc);
                $('#curp').val(respuesta.data[0].curp);
                $('#calle').val(respuesta.data[0].calle);
                $('#n_interior').val(respuesta.data[0].numint);
                $('#n_exterior').val(respuesta.data[0].numext);
                $('#colonia').val(respuesta.data[0].colonia);
                $('#municipio').val(respuesta.data[0].delomun);
                $('#cp').val(respuesta.data[0].cp);
                $('#ced_prof').val(respuesta.data[0].cedpro);
                $('#ced_esp').val(respuesta.data[0].cedesp);*/
            } else {
                $('#Categoria').val(12);
            }
        }
    });
});

$(document).on('blur', '#Nombres', function(){
    let nombres = $(this).val();
    let nombreCompleto = nombres.toUpperCase();
    $("#nombreConstancia").val(nombreCompleto);
});

$(document).on('blur', '#Apellidop', function(){
    let apellidop = $(this).val();
    let nombreConstancia = $("#nombreConstancia").val();
    $("#nombreConstancia").val(nombreConstancia + ' ' + apellidop);
});

$(document).on('blur', '#Apellidom', function(){
    let apellidom = $(this).val();
    let nombreConstancia = $("#nombreConstancia").val();
    $("#nombreConstancia").val(nombreConstancia + ' ' + apellidom);
});

async function EnviarDatos() {
    //InformacionUsuario['tipo_registro'] = document.getElementById('tipo_registro').value;
    let datos = {
        informacion:InformacionUsuario
    }

    console.log(datos)
    try {
        let res = await fetch("./controller/registro.php?accion=Registro", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ datos })
        });
        let response = await res.json();
        console.log(response)
        
        if(response.status){
            window.location.href = "./index.php";
        }else{
            if(response.correo!=null){
                mostrarAviso("warning",response.correo,3000);
            }
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}
