<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Programa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <?php include_once "config/auto_script.php"; ?>
</head>
<body class="bg-light">


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="card-title mb-3 text-center fw-semibold">
                            <i class="ri-file-upload-line me-1"></i>
                            Subir programa 2026
                        </h5>

                        <form action="./controller/catalogos.php?accion=SubirPrograma"
                              method="POST"
                              enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="programa" class="form-label fw-semibold">
                                    Archivo PDF
                                </label>
                                <input
                                    class="form-control"
                                    type="file"
                                    id="programa"
                                    name="programa"
                                    accept=".pdf"
                                    required
                                >
                                <div class="form-text">
                                    Solo se permite subir archivos PDF.
                                </div>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    id="btnSaveFacturacion"
                                    class="btn btn-primary btn-sm">
                                    <i class="ri-save-line me-1"></i>
                                    Guardar
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="http://curso-ameh.com/redireccionPDF.php?recurso=programa&v=<?= time() ?>" target="_blank"
                        class="btn btn-primary mb-3 btn-sm">
                        Ver el programa <?= date("Y") ?>
                        <i class="ri-file-download-line"></i>
                    </a>
                </div>

            </div>
        </div>
        
    </div>
    
</body>
</html>