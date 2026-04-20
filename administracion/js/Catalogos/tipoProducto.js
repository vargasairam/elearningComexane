console.log("JS PARA CATALOGO DE TIPO DE PRODUCTO")

var tipoProducto = $('#tb_tipoProducto').DataTable({

    ajax: {
        url: `${BASE_URL}/administracion/controllers/catalogos.php?accion=getTipos`,
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
            data: 'tipoProducto',
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
            data: 'id',
            render: function(data, type, row, meta) {
                return  `<div class="btn-group mb-3" role="group" aria-label="Default button group">
                    <button class="btn btn-outline-warning px-2 me-2 editar" title="Editar datos" data-tipo="${row.id}"><i class="fas fa-pencil"></i></button>                    
                </div> `
                /* <button class="btn btn-outline-danger px-2 me-2 eliminar" title="Eliminar aviso" data-aviso="${row.id}"><i class="fa-solid fa-trash"></i></button> */
            }
        }

    ],

    "columnDefs": [
        {
            className: "text-justify space",
            "targets": [1],
        },
    ],

    language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.4/i18n/es-ES.json", 
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

//agregar tipoProducto
$(document).on('submit', '#addTipoProducto', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/catalogos.php?accion=addTipoProducto`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#addTipoProducto")
    const modal = $("#modal_tipoProducto");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            tipoProducto.ajax.reload();
            
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

$(document).on('click', '.editar', function(){
    let id_tipoP = $(this).data('tipo');

    $.ajax({
        url: `${BASE_URL}/administracion/controllers/catalogos.php?accion=getTipoProductoById`,
        type: 'POST',
        dataType: 'json',
        data: {
            id_tipoP : id_tipoP
        },
        success: function(data) {
            if(data.length > 0){
                let tipoProducto = data[0].tipoProducto;
                let descripcion = data[0].descripcion;
                
                $('#modal_editarTipoProducto').find('input[name="tipo_producto"]').val(tipoProducto);
                $('#modal_editarTipoProducto').find('textarea[name="descripcion"]').val(descripcion);
                $('#modal_editarTipoProducto').find('input[name="id_update"]').val(id_tipoP);

                $('#modal_editarTipoProducto').modal('show');
            }
            console.log(data);
        }
    });
});

$(document).on('submit', '#updateTipoProducto', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/administracion/controllers/catalogos.php?accion=addTipoProducto`;
    let FORMDATA = new FormData($(this)[0]);
    form = $("#updateTipoProducto")
    const modal = $("#modal_editarTipoProducto");

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            tipoProducto.ajax.reload();
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