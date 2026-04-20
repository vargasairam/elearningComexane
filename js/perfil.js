let flag1 = true;
let flag2 = false;
let flag3 = true;

document.addEventListener("DOMContentLoaded", function () {
    console.log(user)
    init();
    GetEstadosByIdPais(156)

    //EVENTO PARA SOLO PERMITIR NUMEROS EN EL INPUT (para el input del telefono)
    const inputTelefono = document.getElementById('Telefono');
    inputTelefono.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 15); // solo números
    });


    const inputPaisFiscal = document.getElementById('Estado');
    inputPaisFiscal.addEventListener('change', function (e) {
        GetEstadosByIdPais(156,true)
    });

    //FORMS
    const modificar1 = document.getElementById('btn_edit1');
    modificar1.addEventListener('click', function (e) {
        const form = document.getElementById('datos_acceso');
         // Habilitar inputs
            form.querySelectorAll("input, select, textarea").forEach((field) => {
                field.disabled = false;

            });
            console.log(flag1)
        if(flag1){
            document.getElementById('btnSaveAcceso1').classList.remove('d-none');
            document.getElementById('btn_edit1').classList.add('d-none');
            
            
        }else{
            document.getElementById('btnSaveAcceso1').classList.add('d-none');
            document.getElementById('btn_edit1').classList.remove('d-none');
        }
        flag1 = !flag1;
    });

    const btnsave1 = document.getElementById('btnSaveAcceso1');
    btnsave1.addEventListener('click', function (e) {
        btnsave1.classList.add('d-none');
    });
    const btnsave2 = document.getElementById('btnSaveAcceso2');
    btnsave2.addEventListener('click', function (e) {
        btnsave2.classList.add('d-none');
    });

    const modificar2 = document.getElementById('btn_edit2');
    modificar2.addEventListener('click', function (e) {
        const form = document.getElementById('datos_personales');
         // Habilitar inputs
        form.querySelectorAll("input, select, textarea").forEach((field) => {
            if (field.id != 'Categoria') {
                field.disabled = false;
            }

        });
        

        if(flag1){
            document.getElementById('btnSaveAcceso2').classList.remove('d-none');
            document.getElementById('btn_edit2').classList.add('d-none');
            
            
        }else{
            document.getElementById('btnSaveAcceso2').classList.add('d-none');
            document.getElementById('btn_edit2').classList.remove('d-none');
        }
        flag1 = !flag1;
    });

    
    const btnsave3 = document.getElementById('btnSaveAcceso3');
    btnsave3.addEventListener('click', function (e) {
        btnsave3.classList.add('d-none');
    });

    const modificar3 = document.getElementById('btn_edit3');
    modificar3.addEventListener('click', function (e) {
        const form = document.getElementById('datos_ubicacion');
         // Habilitar inputs
        form.querySelectorAll("input, select, textarea").forEach((field) => {
            if (field.id != 'Categoria') {
                field.disabled = false;
            }

        });
        

        if(flag1){
            document.getElementById('btnSaveAcceso3').classList.remove('d-none');
            document.getElementById('btn_edit3').classList.add('d-none');
            
            
        }else{
            document.getElementById('btnSaveAcceso3').classList.add('d-none');
            document.getElementById('btn_edit3').classList.remove('d-none');
        }
        flag1 = !flag1;
    });

    /*const btnsave5 = document.getElementById('btnSaveAcceso5');
    btnsave5.addEventListener('click', function (e) {
        btnsave5.classList.add('d-none');
    });

    const modificar5 = document.getElementById('btn_edit5');
    modificar5.addEventListener('click', function (e) {
        const form = document.getElementById('datos_profesionales');
         // Habilitar inputs
        form.querySelectorAll("input, select, textarea").forEach((field) => {
            if (field.id != 'Categoria') {
                field.disabled = false;
            }

        });
        

        if(flag1){
            document.getElementById('btnSaveAcceso5').classList.remove('d-none');
            document.getElementById('btn_edit5').classList.add('d-none');
            
            
        }else{
            document.getElementById('btnSaveAcceso5').classList.add('d-none');
            document.getElementById('btn_edit5').classList.remove('d-none');
        }
        flag1 = !flag1;
    });*/
    
    //requiere factura
    /*const btnsave4 = document.getElementById('btnSaveFacturacion');
    const switchFactura = document.getElementById('switchFactura');
    const formfacturacion = document.getElementById('datos_facturacion');
    switchFactura.addEventListener('change', function (e) {
        let factura = switchFactura.checked ? 1 : 0;
        if(factura){

            document.getElementById('divInputSFacturacion').classList.remove('d-none');
            // formfacturacion.querySelectorAll("input, select, textarea").forEach((field) => {
            //     field.disabled = false;

            // });
            if (document.getElementById('btn_edit4').classList.contains('d-none')) {
                const form = document.getElementById('datos_facturacion');
                form.querySelectorAll("input, select, textarea").forEach((field) => {
                    if (field.id != 'Categoria') {
                        field.disabled = false;
                    }

                });
            }
        }else{
            document.getElementById('divInputSFacturacion').classList.add('d-none');
            // formfacturacion.querySelectorAll("input, select, textarea").forEach((field) => {
            //     field.disabled = true;

            // });
        }
    });

    const SelectRegimen = document.getElementById('regimen');
    SelectRegimen.addEventListener('change', function (e) {
        GetCFDIs(this.value);
    });

    const selectPais = document.getElementById('Paises_fis');
    selectPais.addEventListener('change', function (e) {
        GetEstadosByIdPais(this.value,true);
    });

    const modificar4 = document.getElementById('btn_edit4');
    modificar4.addEventListener('click', function (e) {
        const form = document.getElementById('datos_facturacion');
        let factura = switchFactura.checked ? 1 : 0;
         // Habilitar inputs
        if(factura){
            form.querySelectorAll("input, select, textarea").forEach((field) => {
                if (field.id != 'Categoria') {
                    field.disabled = false;
                }

            });
        }
        
        

        if(flag3){
            document.getElementById('btnSaveFacturacion').classList.remove('d-none');
            document.getElementById('btn_edit4').classList.add('d-none');
            
            
        }else{
            document.getElementById('btnSaveFacturacion').classList.add('d-none');
            document.getElementById('btn_edit4').classList.remove('d-none');
        }
        flag3 = !flag3;
    });*/

    const inputprefijo = document.getElementById('prefijos');
    inputprefijo.addEventListener('change',function(e){
        if(this.value=='OTRO'){
            otroPrefijo()
        }
        
    });

})

async function GetEstadosByIdPais(id_pais,fiscal = false) {
    console.log(id_pais)
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
        if (response.status) {
            if(fiscal){
                setEstadosFiscalNuevos(response.data.estados);
                
            }else{
                setEstados(response.data.estados);
            }
            
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}



function setEstados(data) {
    console.log(data)
    document.getElementById("Estado").innerHTML = "";
    let select = document.getElementById('Estado');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id;
        option.textContent = element.estado.toUpperCase();
        if (user.estado_id == element.id) {
            option.selected = true;
        }
        select.appendChild(option);
    });
}
function setEstadosFiscalNuevos(data) {
    document.getElementById("Estado_fis").innerHTML = "";
    let select = document.getElementById('Estado_fis');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id;
        option.textContent = element.estado;
        if(userFactruacion!=null){
            if(userFactruacion.estado == element.id){
                option.selected = true;
            }
        }
        select.appendChild(option);
    });
}

function init() {
    GetCatalogosRegistros()
    //GetDatosFacturacioon();
    console.log('entro')
    /*if(userFactruacion!=null){
        console.log('entro')
    }*/
}

async function GetCatalogosRegistros() {
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetCatalogos", {
            method: "GET"
        });
        let response = await res.json();

        if (response.status) {
            setCategorias(response.data.categorias)
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}

function setCategorias(data) {
    let prefijo = document.getElementById('prefijos');
    prefijo.value = user.prefijotxt;
   
    let select = document.getElementById('Categoria');
    /*let Orden = []
    Orden[0] = data[3];
    Orden[1] = data[4];
    Orden[2] = data[0];
    Orden[3] = data[2];
    Orden[4] = data[1];*/
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_categoria;
        option.textContent = element.nombre_categoria;
        if (user.id_categoria == element.id_categoria) {
            option.selected = true;
        }
        select.appendChild(option);
    });
}

function setPrefijos(data) {
    let select = document.getElementById('prefijos');
    let flagOtro = false;
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.prefijo;
        option.textContent = element.prefijo;
        if (user.prefijo == element.prefijo) {
            option.selected = true;
            flagOtro= true;
        }
        if(element.prefijo == 'OTRO' && flagOtro==false){
            option.selected = true;
        } 
        select.appendChild(option);
    });
}
function setPaises(data) {
    let select = document.getElementById('Paises');
    console.log("Datos usuario:")
    console.log(user)

    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_pais;
        option.textContent = element.pais;
        option.dataset.iso = element.iso2;
        option.dataset.lada = element.extension;
        
        if (user.pais_id == element.id_pais) {
            option.selected = true;
            option.dataset.iso = element.iso2;
            option.dataset.lada = element.extension;
            GetEstadosByIdPais(156)
        }
        select.appendChild(option);
    });
}

function setRegimenFiscal(data) {
    let select = document.getElementById('regimen');

    // Crear optgroups
    let grupoFisica = document.createElement('optgroup');
    grupoFisica.label = "Persona Física";

    let grupoMoral = document.createElement('optgroup');
    grupoMoral.label = "Persona Moral";

    data.forEach(element => {

        let option = document.createElement('option');
        option.value = element.id_regimen;
        option.textContent = element.id_regimen + " - " + element.descripcion;

        // Clasificar según la bandera
        if (element.fisico === "Sí") {
            grupoFisica.appendChild(option);
        } else if (element.moral === "Sí") {
            grupoMoral.appendChild(option);
        }
    });

    // Agregar grupos al select si tienen elementos
    if (grupoFisica.children.length > 0) select.appendChild(grupoFisica);
    if (grupoMoral.children.length > 0) select.appendChild(grupoMoral);
}

function setCFDI(data) {
    let select = document.getElementById('cdfi');
    select.innerHTML = ""
    let option = document.createElement('option');
        option.disabled = true;
        if(userFactruacion==null){
            option.selected = true;
        }
        
        option.textContent = 'Selecciona una opción';
        select.appendChild(option);
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_cfdi;
        option.textContent = element.id_cfdi + " - " + element.descripcion;
        if(userFactruacion!=null){
            if(userFactruacion.uso_de_cfdi == element.id_cfdi){
                option.selected = true;
            }
        }
        select.appendChild(option);
    });
}

async function GetDatosFacturacioon(){
    try {
        let res = await fetch("./controller/facturacion.php?accion=GetFacturacion", {
            method: "GET"
        });
        let response = await res.json();
        console.log(response);
        if (response.status) {
            //hay datos
            SetDatosFacturacion(response.data);
        }else{
            SetDatosFacturacionNuevos(response.data)
            //no hay datos
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }

}

function SetDatosFacturacionNuevos(data){
    setPaisesFiscalNuevos(data.paises)
    GetEstadosByIdPais(156,true)
    GetRegimenFiscal()
}

function setPaisesFiscalNuevos(data) {
    let select = document.getElementById('Paises_fis');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_pais;
        option.textContent = element.pais;
        option.dataset.iso = element.iso2;
        option.dataset.lada = element.extension;

        /*if(userFactruacion != null){
            if(userFactruacion.pais == element.id_pais){
                option.selected = true;
                option.textContent = element.pais;
                option.dataset.iso = element.iso2;
                option.dataset.lada = element.extension;
            }
        }else{
            if(element.id == 156){
                option.selected = true;
                option.textContent = element.pais;
                option.dataset.iso = element.iso2;
                option.dataset.lada = element.extension;
            }
        }*/
        
        select.appendChild(option);
    });
}

function SetDatosFacturacion(data){
    //GetRegimenFiscal()
    //setPaisesFiscalNuevos(data.paises)
    GetEstadosByIdPais(156,true)
}
async function GetRegimenFiscal(){
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetRegimenFiscal", {
            method: "GET"
        });
        let response = await res.json();
        console.log(response);
        if (response.status) {
            if(response.data!=null){
                setRegimenFiscal(response.data)
                let valorCFDI = response.data[0].id_regimen;
                if(userFactruacion!=null){
                    valorCFDI = userFactruacion.regimen_fiscal;
                }
                GetCFDIs(valorCFDI)
            }
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}

async function GetCFDIs(id){
    console.log(id)
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetCFDI&id="+id, {
            method: "GET"
        });
        let response = await res.json();
        console.log(response);
        if (response.status) {
            if(response.data!=null){
                setCFDI(response.data)
            }
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
}

function otroPrefijo(){
    document.getElementById("prefijos").classList.add('d-none');
    document.getElementById("prefijo2div").classList.remove('d-none');
}


