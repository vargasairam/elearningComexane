<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <?php
    if(isset($_SESSION['payment_id'])){?>
        <div class="success">
            <strong>
                <?php
                echo "Pago exitoso!";
                ?>
            </strong>
        </div>
        <?php unset($_SESSION['payment_id']); ?>
    <?php 
    }elseif(isset($_SESSION['payment_error'])){?>
        <div class="error">
            <strong>
                <?php
                echo "Error en el pago! ".$_SESSION['payment_error'];
                ?>
            </strong>
        </div>
        <?php unset($_SESSION['payment_error']); ?>
        <?php 
        }
    ?>

    <form action="charge.php" method="post" id="payment-form">
        <div class="form-row">
            <input type="hidden" name="amount" value="<?php echo $alumno->costo ?>00">
            <p><label for="card-element">Crédito o débito</label></p>

            <div id="card-element">
                <!-- A stripe Element will be inserted here -->
            </div>

            <div id="card-errors" role="alert"></div>
            <p><button>Pagar</button></p>
        </div>
    </form>

    <script>
        var publishable_key = "pk_test_51MmJTOGuTfIl032MCUof5RcMfmNgKRVGS3NMWUQOd7TAjJfJupvI2cNBgynNNAsQQnsdTRGppzS9itlVfLR45D4a00GxaW2FWq";
    </script>

    <script src="checkout.js"></script>
</body>
</html>