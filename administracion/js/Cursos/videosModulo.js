console.log("videosCurso.js");
moment.locale('es');

let id_curso = getRequestInfo(); 
let id_modulo = getRequestInfoModulo();

var videosCurso = $('#tb_videosCurso').DataTable({

    ajax: {
        url: `${BASE_URL}/administracion/controllers/cursos.php?accion=getVideosModulo`,
        type: "post",
        data: {
            id_curso: id_curso,
            id_modulo: id_modulo
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
            data: 'tema',
            render: function(data, type, row, meta) {
                return `${data}`;
            }
        },
        { 
            data: 'descripcion',
            render: function(data, type, row, meta) {
                return `${data}`;
            }
        },
        { 
            data: 'ponentes',
            render: function(data, type, row, meta) {
                return `${data}`;
            }
        },       
        { 
            data: 'fecha_texto',
            render: function(data, type, row, meta) {
                return `${moment(data).format('LL')}`;
            }
        },
        { 
            data: 'duracion',
            render: function(data, type, row, meta) {
                return `${data} minutos`;
            }
        },
        { 
            data: 'canal1',
            render: function(data, type, row, meta) {
                return `${data}`;
            }
        },
        { 
            data: 'canal2',
            render: function(data, type, row, meta) {
                if(data == ""){
                    return 'N/A';
                } else {
                    return `${data}`;
                }               
            }
        },
        { 
            data: 'id',
            render: function(data, type, row, meta) {
                return  `<div class="btn-group mb-3" role="group" aria-label="Default button group">
                    <button class="btn btn-outline-warning px-2 me-2 editar" title="Editar datos" data-video="${row.id}"><i class="fas fa-pencil"></i></button>
                    <button class="btn btn-outline-info px-2 me-2 ver-video" title="Ver video" data-video="${row.canal1}"><i class="fa-solid fa-video"></i></button>
                    <button class="btn btn-outline-secondary px-2 me-2 ver-portada" title="Ver portada" data-img="${row.portada_video}"><i class="fa-solid fa-image"></i></button>   
                </div> `
                /* <button class="btn btn-outline-danger px-2 me-2 eliminar" title="Eliminar aviso" data-aviso="${row.id}"><i class="fa-solid fa-trash"></i></button> */
            }
        }
    ],
    "columnDefs": [
        {
            className: "text-justify space",
            "targets": [3],
        },
    ],
    language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.4/i18n/es-ES.json", 
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$(document).on('submit', '#addVideo', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/cursos.php?accion=addVideo`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#addVideo")
    const modal = $("#modal_insertar");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            videosCurso.ajax.reload();            
        } else {
            mostrarAviso(data.status, data.msg);
        }
        modal.modal('hide');
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});

$(document).on('click', '.editar', function(e){
    e.preventDefault();
    let id_video = $(this).data('video');

    $.ajax({
        url: `${BASE_URL}/administracion/controllers/cursos.php?accion=getVideoById`,
        type: 'POST',
        dataType: 'json',
        data: {
            id_video : id_video
        },
        success: function(data) {
            console.log(data);
            if(data.length > 0){
                let titulo = data[0].titulo;
                let tema = data[0].tema;
                let ponentes = data[0].ponentes;
                let descripcion = data[0].descripcion;
                let fecha_texto = moment(data[0].fecha_texto).format('YYYY-MM-DD');
                let canal1 = data[0].canal1;
                let canal2 = data[0].canal2;
                let duracion = data[0].duracion;
                
                $('#titulo').val(titulo);
                $('#tema').val(tema);
                $('#ponentes').val(ponentes);
                $('#detalles').val(descripcion);
                $('#f_publicacion').val(fecha_texto);
                $('#canal1').val(canal1);
                $('#canal2').val(canal2);
                $('#duracion').val(duracion);
                $('#modal_update').find('input[name="id_update"]').val(data[0].id);
                $('#modal_update').modal('show');
            }
        }
    });
});

$(document).on('submit', '#updateVideo', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/cursos.php?accion=addVideo`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#updateVideo")
    const modal = $("#modal_update");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            videosCurso.ajax.reload();            
        } else {
            mostrarAviso(data.status, data.msg);
        }
        modal.modal('hide');
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});

//ver portada del video
$(document).on('click', '.ver-portada', function(e){
    e.preventDefault();
    let img = $(this).data('img');
    $('#div_imagen').html(`<img src="${BASE_URL}imgs/cursos_posters/portadas_videos/${img}" class="img-fluid rounded">`);
    $('#modalImagen').modal('show');
});

//ver video
$(document).on('click', '.ver-video', function(e){
    e.preventDefault();
    let video = $(this).data('video');
    document.getElementById("video_preview").innerHTML = `<iframe 
        src="https://player.vimeo.com/video/${video}?autoplay=1"
        style="position:absolute;top:0;left:0;width:100%;height:100%;"
        frameborder="0"
        allow="autoplay; encrypted-media"
        allowfullscreen>
    </iframe>`;

    $('#verVideo').modal('show');    
});


function getRequestInfo() {
    const params = new URLSearchParams(window.location.search);
    const data = params.get("id_curso");
    idRequest = data;
    return idRequest;
}

function getRequestInfoModulo() {
    const params = new URLSearchParams(window.location.search);
    const data = params.get("id_modulo");
    idRequest = data;
    return idRequest;
}
