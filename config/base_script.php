

<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
    integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
    crossorigin="anonymous">
</script>

<!-- JS de DataTables -->
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

<!-- SweetAlert2 JS Libreria -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Moment JS Libreria -->
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

<!-- Currency JS Libreria -->
<script src="https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"></script>

<!-- ImagesLoaded JS Libreria -->
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>

<!-- Vimeo API Player JS Libreria -->
<script src="https://player.vimeo.com/api/player.js"></script>

<script src="js/main.js"></script>

<?php
	if(isset($_SESSION[AMBIENTE]['usuario']['rol'])) {
		$id_rol = $_SESSION[AMBIENTE]['usuario']['rol'];
	} else {
		$id_rol = "";
	}
?>

<script>
	var BASE_URL = "http://localhost/elearningComexane/";
	//var BASE_URL = "<?php echo BASE_URL; ?>";
</script>


<script>
	let id_rol = "<?= $id_rol ?>";
	if(id_rol != "") {
		document.addEventListener("DOMContentLoaded", () => {
			menu();
		});
	}
    

    // timeOut es en milisegundos
	function mostrarAviso(clase, mensaje, timeOut = 2500) {
		var message = mensaje;
		var title = "Mensaje";
		var type = clase;
		toastr[type](message, title, {
			positionClass: "toast-top-right",
			closeButton: false,
			progressBar: true,
			newestOnTop: true,
			timeOut: timeOut,
			debug: false,
			onclick: null
		});
	}

	<?php
	 	require_once __DIR__.'/../model/helper.php';
		$H = new Helper();
		$mensaje = $H->verMensaje();
		if(isset($mensaje['texto']) && $mensaje['texto'] != "") { ?>
			mostrarAviso("<?= $mensaje['clase'] ?>", "<?= $mensaje['texto'] ?>")
		<?php } 
	?>
</script>

<script>
	if(id_rol == "alumno") {
		mostrarProductosEnCarrito();
	} else {
		console.log("no es alumno");
	}
	
	// Funcion para mostrar productos en el carrito
	
	function mostrarProductosEnCarrito() {
		let url = `${BASE_URL}/controller/alumno.php?accion=ProductosEnCarrito`;
		$.ajax({
			url: url,
			type: 'GET',
			success: function(response) {
				let data = JSON.parse(response);
				if(data.length > 0){
					let html = '';
					html += `<li class="mb-2"> <strong>Carrito</strong> </li>`
					let totalPagar = 0;
					data.forEach(function(item){
						precio = item.precio * item.cantidad;
						html += `<li  class="d-flex justify-content-between align-items-center mb-2">
							<div>
								<small>${item.titulo}</small><br>
								<small>Cantidad: ${item.cantidad}</small><br>
								<small class="text-muted">${currency(precio, { symbol: '$', decimal: '.', separator: ',' }).format()}</small>
							</div>
							<button class="btn btn-sm" data-id="${item.id}">x</button>
						</li>`;

						$('#carrito_compras').html(html);
						$('#carrito_badge').html(`<span class="cart-badge">${data.length}</span>`);
						$('#btn_pagar').removeClass('d-none');
						totalPagar += parseFloat(item.precio);
					});

					html += `<li>
						<hr class="dropdown-divider" />
					</li>

					<li class="d-flex justify-content-between">
						<strong>Total:</strong>
						<strong>${currency(totalPagar, { symbol: '$', separator: ',' }).format()}</strong>
					</li>
					
					<li id="btn_pagar" class="mt-2">
						<a href="?seccion=pagar" class="btn btn-iconos w-100">
							Ir a pagar
						</a>
					</li>`
					$('#carrito_compras').html(html);
				} else {
					$('#carrito_compras').html('<li>No hay productos en el carrito</li>');
					$('#btn_pagar').addClass('d-none');
				}
			}
		});
	}
</script>

<script>
	function openModalLoading(title = 'Cargando...', html = 'Por favor espere...') {
		window.Swal.fire({
			title: title,
			html: html,
			allowOutsideClick: false,
			didOpen: () => {
				window.Swal.showLoading();
			}
		});
	}

	function closeModalLoading() {
		Swal.close();
	}
</script>

<?php
	if (isset($scripts_js["js"])) {
		foreach ($scripts_js["js"] as $js) {
			echo '<script src="' . $js . '"></script>';
		}
	}
?>