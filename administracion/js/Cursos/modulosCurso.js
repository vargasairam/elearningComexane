console.log("modulosCurso.js");

let id_curso = getRequestInfo(); 

var modulosCurso = $('#tb_modulosCurso').DataTable({

    ajax: {
        url: `${BASE_URL}/administracion/controllers/cursos.php?accion=getModulosCurso`,
        type: "post",
        data: {
            id_curso: id_curso
        }
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            // Columna de numeración
            "render": function (data, type, row, meta) {
                // meta.row es el índice de la fila (base 0)
                // meta.settings._iDisplayStart es el índice de la primera fila en la página actual
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { 
            data: 'titulo',
            render: function(data, type, row, meta) {
                return `<span>${data}</span>`;
            }
        },
        { 
            data: 'detalles',
            render: function(data, type, row, meta) {
                return `${data}`;
            }
        },
        { 
            data: 'f_inicio',
            render: function(data, type, row, meta) {
                return `${moment(data).format('DD/MM/YYYY')}`;
            }
        },
        { 
            data: 'f_fin',
            render: function(data, type, row, meta) {
                return `${moment(data).format('DD/MM/YYYY')}`;
            }
        },
        { 
            data: 'id',
            render: function(data, type, row, meta) {
                return  `<div class="btn-group mb-3" role="group" aria-label="Default button group">
                    <button class="btn btn-outline-warning px-2 me-2 editar" title="Editar datos" data-modulo="${row.id}"><i class="fas fa-pencil"></i></button>
                    <a href="${BASE_URL}administracion/?seccion=modulos&accion=videos&id_modulo=${row.id}&id_curso=${id_curso}"><button class="btn btn-outline-primary px-2 me-2 subir-videos" title="Subir videos" data-modulo="${row.id}"><i class="fas fa-video"></i></button></a>   
                    <button class="btn btn-outline-secondary px-2 me-2 ver-poster" title="Ver póster" data-img="${row.poster_modulo}"><i class="fa-solid fa-image"></i></button>   
                </div> `
                /* <button class="btn btn-outline-danger px-2 me-2 eliminar" title="Eliminar aviso" data-aviso="${row.id}"><i class="fa-solid fa-trash"></i></button> */
            }
        }
    ],
    language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.4/i18n/es-ES.json", 
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$(document).on('submit', '#addModulo', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/cursos.php?accion=addModulo`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#addModulo")
    const modal = $("#modal_insertar");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            modulosCurso.ajax.reload();
            
        } else {
            mostrarAviso(data.status, data.msg);
        }
        //Swal.close();
        modal.modal('hide');
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});

$(document).on('click', '.editar', function(e){
    e.preventDefault();
    let id_modulo = $(this).data('modulo');

    $.ajax({
        url: `${BASE_URL}/administracion/controllers/cursos.php?accion=getModuloById`,
        type: 'POST',
        dataType: 'json',
        data: {
            id_modulo : id_modulo
        },
        success: function(data) {
            console.log(data);
            if(data.length > 0){
                let titulo = data[0].titulo;
                let detalles = data[0].detalles;
                let fecha_inicio = moment(data[0].f_inicio).format('YYYY-MM-DD');
                let fecha_fin = moment(data[0].f_fin).format('YYYY-MM-DD');
                
                $('#titulo').val(titulo);
                $('#detalles').val(detalles);
                $('#fecha_inicio').val(fecha_inicio);
                $('#fecha_fin').val(fecha_fin);
                $('#modal_update').find('input[name="id_update"]').val(data[0].id);
                $('#modal_update').modal('show');
            }
        }
    });
});

$(document).on('submit', '#updateModulo', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/cursos.php?accion=addModulo`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#updateModulo")
    const modal = $("#modal_update");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            modulosCurso.ajax.reload();
            
        } else {
            mostrarAviso(data.status, data.msg);
        }
        //Swal.close();
        modal.modal('hide');
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});

//ver portada del video
$(document).on('click', '.ver-poster', function(e){
    e.preventDefault();
    let img = $(this).data('img');
    $('#div_imagen').html(`<img src="${BASE_URL}imgs/cursos_posters/modulos_posters/${img}" class="img-fluid rounded">`);
    $('#modalImagen').modal('show');
});


function getRequestInfo() {
    const params = new URLSearchParams(window.location.search);
    const data = params.get("id_curso");
    idRequest = data;
    return idRequest;
}
