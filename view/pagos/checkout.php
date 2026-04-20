<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  
</head>

<body> -->
  <div class="">
    

    <?php if ($alumno->categoria_id == 1 || $alumno->categoria_id == 2) { ?>

    </div>
    <?php } ?>
  <!-- Publico -->
  <?php
  if ($alumno->categoria_id == 3 || $alumno->categoria_id == 4 || $alumno->categoria_id == 5|| $alumno->categoria_id == 6) {

    if ($alumno->categoria_id == 5 && !isset($_GET['mod'])) { ?>
    
      <div class="card border-danger">
        <div class="card-body text-danger fw-semibold">
          <i class="fas fa-info-circle me-2"></i>
          ¡ES IMPORTANTE QUE PRIMERO SELECCIONES EL MÓDULO QUE QUIERAS PAGAR!
        </div>
      </div>
    <?php } ?>


<?php
if ($alumno->categoria_id != 5 || isset($_GET['mod'])) { ?>

    <div class="row mt-3">

  <!-- Columna izquierda (formulario) -->
  <div class="col-md-7">
    <div class="pricingr-plan recommended">
      <form action="CreateCharge.php" method="post" id="payment-form">
        <?php
          $montoStripe = (int) round($alumno->costo * 100);
        ?>

        <input type="hidden" name="pago" value="<?php echo $montoStripe ?>">
        <!-- <input type="hidden" name="pago" value="<?php //echo $alumno->costo ?>00"> -->
        <input type="hidden" name="description" value="Curso HBE 2026 ID <?php echo $alumno->id ?>">
        <input type="hidden" name="email" value="<?php echo $alumno->email ?>">
        <input type="hidden" name="name" value="<?php echo $alumno->nombre . " " . $alumno->apellidos ?>">
        <input type="hidden" name="id" value="<?php echo $alumno->id ?>">

        <h3>Formulario de pago</h3>

        <?php if (isset($_GET['mod']) && !empty($_GET['mod'])) { ?>
          <input type="hidden" name="modulo" value="<?php echo $_GET['mod'] ?>">
        <?php } ?>

        <label for="card-element">
          Ingresa los datos de tu Tarjeta de Crédito o Débito
        </label>

        <div id="card-element"></div>

        <div id="card-errors" role="alert"></div>



        <?php
        $disabledPagar = '';
        $styleBtnPagar = '';
        //SI TODAVIA NO CONFIRMA SI QUIERE FACTURA O NO, SE LE BLOQUEA EL BTN DE PAGAR
        if($user->requiere_factura==0){ 
          $disabledPagar = 'disabled';
          $styleBtnPagar = 'style="background: #c2c2c2;border-color: #c2c2c2;color: black;"';
        }

        //SI CONFIRMO QUE QUIERE FACTURA PERO NO TIENE DATOS DE FACTURACION, SE LE BLOQUEA EL BTN DE PAGAR
        if($user->requiere_factura==1){ 
          if(!$F->TieneDatosFactura($id)){  
            $disabledPagar = 'disabled';
            $styleBtnPagar = 'style="background: #c2c2c2;border-color: #c2c2c2;color: black;"';
          }
        } ?>
        
        <button id="btnPago" class="btn btn-primary mt-3 mb-3" <?= $disabledPagar ?> <?= $styleBtnPagar ?>>Pagar ahora</button>

        <div class="spinner-border text-danger d-none mt-3" role="status" id="sppiner">
          <span class="visually-hidden">Loading...</span>
        </div>
        

      </form>
    </div>
  </div>

  <?php /*if($alumno->categoria_id == 4){
    $tieneBeca = $A->UsuarioTieneBeca($alumno->id);
  }
  */
  
  ?>

  <!-- Columna derecha (total o estatus) -->
  <div class="col-md-5">
    
    <?php if ($alumno->costo > 0) { ?>
      <div class="p-4 border rounded text-center mb-3">
        <div class="fw-semibold text-uppercase mb-2">Total a pagar</div>
        <!-- SI NO TIENE BECA APLICADA MOSTRARA EL PRECIO NORMAL -->
        <?php if (!isset($alumno->costoCopia)): ?>
          <div class="fw-bold fs-4">$<?php echo $alumno->costo ?> MXN</div>
        <?php endif; ?>
        <!-- SI TIENE BECA APLICADA MOSTRARA EL PRECIO TACHADO Y EL CON DESCUENTO -->
        <?php if (isset($alumno->costoCopia)): ?>
          <div class="fw-bold fs-4 text-decoration-line-through">$<?php echo $alumno->costoCopia ?> MXN</div>
          <div class="fw-bold fs-4 ">$<?php echo $alumno->costo ?> MXN</div>
          
        <?php endif; ?>
      </div>
    <?php } ?>
    <?php if (isset($_GET['mod']) && !empty($_GET['mod'])) { ?>
    
      <div class="d-flex align-items-center p-3 mb-3 border-start border-4 border-danger bg-light bg-opacity-50 rounded gap-3">
        <i class="bi bi-credit-card fs-4 text-primary"></i>
        <div>
          <div class="fw-semibold text-muted">Está a punto de pagar el módulo: <?php echo $_GET['mod'] ?></div>
        </div>
      </div>

    <?php } ?>

    <?php if(!isset($alumno->descuento) && $alumno->descuento==null && $alumno->categoria_id==4 && !$bloquearCategoria): ?>
      <div class="p-4 border rounded mb-3">
        <div class="fw-semibold text-uppercase mb-2 text-center">
            Código de beca
        </div>
        <form class="form_register" method="POST" action="./controller/alumno.php?accion=AplicarBeca" autocomplete="off">
        <div class="input-group">
          
            <input 
                type="text" 
                class="form-control text-center"
                id="codigo"
                name="codigo"
                placeholder="Ingresa tu código"
                autocomplete="off"
            >
            <button class="btn btn-primary" type="submit">
                Aplicar
            </button>
          
        </div>
        </form>

        <small class="text-muted d-block text-center mt-2">
            Si cuentas con un código de beca, ingrésalo aquí.
        </small>
    </div>


    <?php endif; ?>
    <?php if(isset($alumno->descuento) && $alumno->descuento!=null && $alumno->categoria_id==4 && !$bloquearCategoria): ?>
      <div class="container mt-4">
        <div class="card border-success shadow-sm">
          <div class="card-body text-center">
            <div class="d-flex align-items-center justify-content-center gap-2">
              <i class="ri-checkbox-circle-fill text-success fs-1"></i>
              <h5 class="fw-semibold mb-0">Código aplicado correctamente</h5>
            </div>

            <p class="mb-2">El descuento ya fue aplicado a tu compra.</p>

            <span class="badge bg-success">Código utilizado: <strong><?= $alumno->codigo ?></strong></span>
          </div>
        </div>
      </div>
    <?php endif; ?>

    



    <?php if ($alumno->costo == 0) { ?>
      <div class="p-4 border rounded text-center mb-3">
        <div class="fw-semibold text-uppercase small mb-2">Estatus de Registro</div>
        <div class="fw-bold fs-5">SIN CONFIRMAR</div>
      </div>
    <?php } ?>
  </div>

</div>


    <?php
}
    ?>
    </div>
  <?php } else {

  }
  ?>

  <script>
    const key = "<?= key_stripe_public ?>";
    var stripe = Stripe(key);

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
      base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
          color: '#aab7c4'
        }
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
      }
    };
    const submit = 1




    // Create an instance of the card Element.
    var card = elements.create('card', { style: style });

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.

    card.addEventListener('change', function (event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
      
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
      event.preventDefault();

      stripe.createToken(card).then(function (result) {
        if (result.error) {
          // Inform the user if there was an error.
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server.
          
            console.log("pagando")
            stripeTokenHandler(result.token);
          

        }
      });
    });

    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);

      // Submit the form
      
        form.submit();
        let btnPago = document.getElementById("btnPago").classList.add("d-none")
        let sppiner = document.getElementById("sppiner").classList.remove("d-none")
       
      
    }


  </script>



<!-- </body>

</html> -->