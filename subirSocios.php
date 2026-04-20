<?php
    if(!isset($_GET['acceso'])){
        header('Location: https://curso-ameh.com/signin.php');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Socios</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="fw-semibold text-center mb-4">Registro de socios</h3>

            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="https://curso-ameh.com/imgs/Logo-AMEH.png" style="max-width:120px;">
                    </div>

                    <h4 class="card-title mb-4 text-center">Ingresar correo</h4>

                    <form action="controller/subirSocios.php?accion=subir" method="POST">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                placeholder="ejemplo@correo.com"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select name="categoria" required id="categoria" class="form-select">
                                <option value="" selected disabled>Selecciona una opción</option>
                                <option value="1">Socio AMEH Vigente al 2026</option>
                                <option value="3">Socios AMEH vigentes 2025</option>
                                <option value="2">Residente Hematología</option>
                            </select>
                            <div class="form-text">
                                Verifica que el correo pertenezca a la categoría seleccionada antes de continuar.
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            Esta sección solo agrega el correo a la lista de la categoría seleccionada. No crea cuentas de usuario.
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn text-white" style="background: #c02a29;" >
                                Enviar
                            </button>
                        </div>

                        

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="./js/subirSocios.js"></script>

</body>
</html>
