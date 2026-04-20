document.addEventListener("DOMContentLoaded", function () {
    //FORMS
    const btnAceptarFactura = document.getElementById('facturaAceptar');
    btnAceptarFactura.addEventListener('click', function (e) {
        GetDatosFacturacioon()
        const myModal = new bootstrap.Modal(document.getElementById('modalFacturacion'));
        myModal.show(); 
    });

    const inputPaisFiscal = document.getElementById('Paises_fis');
    inputPaisFiscal.addEventListener('change', function (e) {
        GetEstadosByIdPais(this.value,true)
    });

    const SelectRegimen = document.getElementById('regimen');
    SelectRegimen.addEventListener('change', function (e) {
        GetCFDIs(this.value);
    });

})

async function GetDatosFacturacioon(){
    try {
        let res = await fetch("./controller/facturacion.php?accion=GetFacturacion", {
            method: "GET"
        });
        let response = await res.json();
        console.log(response);
        if (!response.status) {
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
        option.value = element.id;
        option.textContent = element.pais;
        if(element.id == 156){
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
        option.textContent = element.descripcion;

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
        option.selected =true;
        option.value = '';
        option.textContent = 'Selecciona una opción';
        select.appendChild(option);
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id_cfdi;
        option.textContent = element.descripcion;
        select.appendChild(option);
    });
}

async function GetEstadosByIdPais(id_pais,fiscal = false) {
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
                
            }
            
        }

    } catch (err) {
        console.error("Error en fetch:", err);
    }
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