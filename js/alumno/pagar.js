/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 14/04/2026
Fecha de Ultima Actualizacion: 
Actualizo: */

//Moment js en español
moment.locale('es');
let totalPagar = 0;

document.addEventListener("DOMContentLoaded", async function () {
    openModalLoading('Consultando información...', 'Por favor espere un momento...');
    carrito = await getCarrito();  
    closeModalLoading()    
});

//Obtener el carrito
async function getCarrito() {
    return await $.ajax({
        url: `${BASE_URL}controller/alumno.php?accion=ProductosEnCarrito`,
        type: 'POST',
        dataType: 'json',
        success: function (respuesta) {
            let html = '';
            if(respuesta.length > 0){                
                respuesta.forEach(function(item){
                    html += `<div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="fw-bold mb-1">${item.titulo}</h6>
                            <p class="text-muted mb-1">
                                ${item.descripcion}
                            </p>
                            <small class="text-secondary">Cantidad: ${item.cantidad}</small>
                            <input type="hidden" name="id_curso[]" value="${item.id_curso}">
                            <input type="hidden" name="cantidad[]" value="${item.cantidad}">
                        </div>

                        <div class="text-end">
                            <h6 class="fw-bold text-success mb-0">${currency(parseFloat(item.precio) * parseFloat(item.cantidad), { symbol: '$', decimal: '.', separator: ',' }).format()}</h6>
                        </div>
                    </div>`;
                    totalPagar += parseFloat(item.precio) * parseFloat(item.cantidad);
                });
                $('#resumen_compra').html(html);
                $('#total_pagar').append(`<h5 class="fw-bold text-primary mb-0">${currency(totalPagar, { symbol: '$', decimal: '.', separator: ',' }).format()}</h5>`);
            } else {
                html += `<div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                    <div>
                        <h6 class="fw-bold mb-1">No hay productos en el carrito</h6>
                    </div>
                </div>`;
                $('#resumen_compra').html(html);
                $('#btn_proceder_pago').addClass('d-none');
                $('#total_pagar').append(`<h5 class="fw-bold text-primary mb-0">${currency(totalPagar, { symbol: '$', decimal: '.', separator: ',' }).format()}</h5>`);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', status, error);
            return false;
        }
    });
}

//Proceder al pago
$(document).on('submit', '#form-pagar', function(e){
    e.preventDefault();
    openModalLoading('Procesando información...', 'Por favor espere un momento...');
    let url = `${BASE_URL}controller/alumno.php?accion=procederPago`
    FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('totalPago', totalPagar);

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        console.log(data);
        window.location.href = data;
    })
    .catch(err => {
        mostrarAviso('error', "Hubo un problema al procesar el pago, intente de nuevo");
        console.error('Error en el fetch:', err);
        closeModalLoading();
        //alert('Error de conexión 💀');
    });
});