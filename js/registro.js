document.addEventListener("DOMContentLoaded", function (){
    init();

    //EVENTO PARA SOLO PERMITIR NUMEROS EN EL INPUT (para el input del telefono)
    const inputTelefono = document.getElementById('Telefono');
    inputTelefono.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 15); // solo números
    });

    const inputPais = document.getElementById('Paises');
    inputPais.addEventListener('change',function(e){
        GetEstadosByIdPais(this.value)
    });

    const inputprefijo = document.getElementById('prefijos');
    inputprefijo.addEventListener('change',function(e){
        if(this.value=='OTRO'){
            otroPrefijo()
        }
        
    });

    const selectCategoria = document.getElementById('Categoria');
    selectCategoria.addEventListener('change',function(e){
        document.getElementById('codigo').value = '';
        console.log(this.value);
        if(this.value==4){
            console.log('entro');
            document.getElementById('divCodigo').classList.remove('d-none');
        }else{
            console.log('no entro');
            document.getElementById('divCodigo').classList.add('d-none');
        }
        
    });
})


async function GetCatalogosRegistros() {
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetCatalogos", {
            method: "GET"
        });
        let response = await res.json();
        
        if(response.status){
            setCategorias(response.data.categorias)
            setPrefijos(response.data.prefijos)
            setPaises(response.data.paises)
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
    let Orden = []
    Orden[0] = data[3];
    Orden[1] = data[4];
    Orden[2] = data[0];
    Orden[3] = data[2];
    Orden[4] = data[1];
    Orden.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id;
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
        option.value = element.id;
        option.textContent = element.pais;
        if(element.id == 156){
            option.selected = true;
            GetEstadosByIdPais(element.id)
        }
        select.appendChild(option);
    });
}

function setEstados(data){
    document.getElementById("Estado").innerHTML = "";
    let select = document.getElementById('Estado');
    data.forEach(element => {
        let option = document.createElement('option');
        option.value = element.id;
        option.textContent = element.estado;
        select.appendChild(option);
    });
}

function init(){
    GetCatalogosRegistros()
}

function otroPrefijo(){
    document.getElementById("prefijodiv").classList.add('d-none');
    document.getElementById("prefijo2div").classList.remove('d-none');
}