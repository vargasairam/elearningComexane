console.log("JS PARA CATALOGO CURSOS/VIDEOS");

var cursos = $('#tb_cursos').DataTable({
    ajax: {
        url: `${BASE_URL}/administracion/controllers/catalogos.php?accion=getCursos`,
        type: "post",
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
                return `${data}`;
            }
        },
        { 
            data: 'tipo_producto',
            render: function(data, type, row, meta) {
                return `<span>${data}</span>`;
            }
        },        
        { 
            data: 'descripcion',
            render: function(data, type, row, meta) {
                return `${data}`;
            }
        },
        { 
            data: 'fecha_hora_inicio',
            render: function(data, type, row, meta) {
                return `${moment(data).format('DD/MM/YYYY')}`;
            }
        },
        { 
            data: 'fecha_hora_fin',
            render: function(data, type, row, meta) {
                return `${moment(data).format('DD/MM/YYYY')}`;
            }
        },
        { 
            data: 'precio',
            render: function(data, type, row, meta) {
                return `${currency(data, { symbol: '$', decimal: '.', separator: ',' }).format()}`;
            }
        },
        { 
            data: 'modulos',
            render: function(data, type, row, meta) {
                modulos = data == 1 ? row.n_modulos : 'NA';
                return `${modulos}`;
            }
        },
        { 
            data: 'porcentaje_constancia',
            render: function(data, type, row, meta) {
                return `${data}%`;
            }
        },
        { 
            data: 'habilitado',
            render: function(data, type, row, meta) {
                checked = data == 0 ? 'checked' : '';
                if(data == 1){
                    estatus = `<span class="badge bg-danger">Inactivo</span>
                    <div class="form-check form-switch d-flex justify-content-center">
                        <input class="form-check-input habilitado" type="checkbox" data-habilitado="${data}" data-curso="${row.id}" ${checked}>
                    </div>`;
                    
                } else {
                    estatus = `<span class="badge bg-success">Activo</span>
                    <div class="form-check form-switch d-flex justify-content-center">
                        <input class="form-check-input habilitado" type="checkbox" data-habilitado="${data}" data-curso="${row.id}" ${checked}>
                    </div>`;
                }
                return `${estatus}`;
            }
        },
        { 
            data: 'id',
            render: function(data, type, row, meta) {
                btn_video = '';
                btn_modulos = '';

                if(row.modulos == 1){
                    btn_modulos = `<a href="${BASE_URL}administracion/?seccion=modulos&id_curso=${row.id}"><button class="btn btn-outline-secondary px-2 me-2" title="Ver módulos" data-curso="${row.id}"><i class="fas fa-eye"></i></button></a>`;                    
                } else {
                    btn_video = `<a href="${BASE_URL}administracion/?seccion=cursos&accion=videos&id_curso=${row.id}"><button class="btn btn-outline-info px-2 me-2 editar" title="Subir video" data-curso="${row.id}"><i class="fas fa-file-video"></i></button></a>`;
                }

                return  `<div class="btn-group mb-3" role="group" aria-label="Default button group">
                    <button class="btn btn-outline-warning px-2 me-2 editar" title="Editar datos" data-curso="${row.id}"><i class="fas fa-pencil"></i></button>                    
                    ${btn_video} ${btn_modulos}                
                </div> `
                /* <button class="btn btn-outline-primary px-2 me-2 cargar-constancia" title="Cargar constancia" data-curso="${row.id}"><i class="fa fa-file-text" aria-hidden="true"></i></button>   */

                /* <button class="btn btn-outline-danger px-2 me-2 eliminar" title="Eliminar aviso" data-aviso="${row.id}"><i class="fa-solid fa-trash"></i></button> */
            }
        }

    ],

    "columnDefs": [
        {
            className: "text-justify space",
            "targets": [3],
        },
        {
            className: "text-center space",
            "targets": [0, 1, 7, 8, 9],
        },
    ],

    language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.4/i18n/es-ES.json", 
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$(document).on('change', '.tipos', function(){
    let value = $(this).val();
    if(value == 3){
        $('.modulos').addClass('d-none');
    } else {
        $('.modulos').removeClass('d-none');
    }
});

$(document).on('change', '.mods', function(){
    let value = $(this).val();
    console.log(value);
    if(value == 1){
        $('.n_modulos').removeClass('d-none');
    } else {
        $('.n_modulos').addClass('d-none');
    }
});

//agregar curso
$(document).on('submit', '#addCurso', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/catalogos.php?accion=addCurso`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#addCurso")
    const modal = $("#modal_curso");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            cursos.ajax.reload();
            
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

$(document).on('change', '#modulos', function(){
    let value = $(this).val();
    if(value == 1){
        $('.n_modulos').removeClass('d-none');
    } else {
        $('.n_modulos').addClass('d-none');
    }
});

$(document).on('click', '.editar', function(){
    let id_curso = $(this).data('curso');

    $.ajax({
        url: `${BASE_URL}/administracion/controllers/catalogos.php?accion=getCursoById`,
        type: 'POST',
        dataType: 'json',
        data: {
            id_curso : id_curso
        },
        success: function(data) {
            if(data.length > 0){
                let id_tipoProducto = data[0].id_tipoProducto;
                let titulo = data[0].titulo;
                let descripcion = data[0].descripcion;
                let fecha_hora_inicio = data[0].fecha_hora_inicio;
                let fecha_hora_fin = data[0].fecha_hora_fin;
                let precio = data[0].precio;
                let modulos = data[0].modulos;
                let porcentaje_constancia = data[0].porcentaje_constancia;
                let habilitado = data[0].habilitado;

                if(modulos == 1){
                    $('.n_modulos').removeClass('d-none');
                    $('#n_modulos').val(data[0].n_modulos);
                } else {
                    $('.n_modulos').addClass('d-none');
                }
                
                $('#tipoCurso').val(id_tipoProducto);
                $('#titulo').val(titulo);
                $('#descripcion').val(descripcion);
                $('#f_inicio').val(fecha_hora_inicio);
                $('#f_fin').val(fecha_hora_fin);
                $('#modal_update').find('input[name="precio"]').val(precio);
                $('#modulos').val(modulos);
                $('#modal_update').find('input[name="porcentaje_constancia"]').val(porcentaje_constancia);
                $('#habilitado').val(habilitado);
                $('#modal_update').find('input[name="id_update"]').val(data[0].id);
                $('#modal_update').modal('show');
            }
        }
    });
});

$(document).on('submit', '#updateCurso', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/catalogos.php?accion=addCurso`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#updateCurso")
    const modal = $("#modal_update");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            cursos.ajax.reload();
            modal.modal('hide');
        } else {
            mostrarAviso(data.status, data.msg);
        }
        
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});

//switch para habilitar/deshabilitar curso
$(document).on('change', ".habilitado", function(){
    id_curso = $(this).data('curso')
    bef_hab = parseFloat($(this).data('habilitado'));
    var habilitado; 
    if(bef_hab == 0){
        habilitado = 1;
    } else {
        habilitado = 0;
    }
    let FORMDATA = new FormData();
    const url = `${BASE_URL}/administracion/controllers/catalogos.php?accion=updHabilitadoCurso`;
    FORMDATA.append('habilitado', habilitado);
    FORMDATA.append('id_curso', id_curso);

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            cursos.ajax.reload();
        } else {
            mostrarAviso(data.status, data.msg);
        } 
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});