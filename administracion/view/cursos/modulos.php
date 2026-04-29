<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="row g-6 mt-0">
        <div class="col-xxl mt-3">            
            <div>
                <div class="card-header">
                    <div class="row m-3 my-0 justify-content-between">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto">
                            <a href="./?seccion=catalogos&accion=cursos" class="btn add-new btn-light" role="button">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    <span class="d-none d-sm-inline-block">Regresar</span>
                                </span>
                            </a>
                        </div>

                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto">
                            <button class="btn btn-inicio add-new btn-primary" tabindex="0" aria-controls="tb_empresas" type="button" data-bs-toggle="modal" data-bs-target="#modal_insertar"><span><span class="d-flex align-items-center gap-2"><i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline-block">Agrear módulo</span></span></span></button>
                        </div>
                    </div>                
                </div>
                <div class="card-body">
                    <!-- TABLA EMPRESAS -->
                    <div class="card-datatable">
                        <table id="tb_modulosCurso" class="datatables-users table">
                            <thead class="border-top">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre del módulo</th>
                                    <th>Detalles</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha de fin</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="modal_insertar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Nuevo módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="addModulo" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">Título del módulo</label>
                                <input type="text" name="titulo" class="form-control" required placeholder="Ingrese título del módulo">
                                <input type="hidden" name="id_curso" value="<?= $id_curso ?>">
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Detalles</label>
                                <textarea name="detalles" class="form-control" required></textarea>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha de inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha de fin</label>
                                <input type="date" name="fecha_fin" class="form-control" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Póster módulo<small>(Debe ser una imagen .jpg, .png o .jpeg)</small></label>
                                <input type="file" name="poster_modulo" class="form-control" placeholder="Ingrese el póster del módulo" accept=".jpg,.png,.jpeg" required>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-inicio waves-effect waves-light">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="modal_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="updateModulo">
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">Título del módulo</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" required placeholder="Ingrese título del módulo">
                                <input type="hidden" name="id_curso" value="<?= $id_curso ?>">
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Detalles</label>
                                <textarea  id="detalles" name="detalles" class="form-control" required></textarea>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha de inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha de fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Póster módulo<small>(Debe ser una imagen .jpg, .png o .jpeg)</small></label>
                                <input type="file" name="poster_modulo" class="form-control" placeholder="Ingrese el póster del módulo" accept=".jpg,.png,.jpeg">
                                <input type="hidden" name="id_update" id="id_update">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning waves-effect waves-light">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    let n_modulos = <?= $curso[0]->n_modulos ?>;
</script>

<?php
    $scripts_js = [
        "js" => [
            //"https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js",
            "js/Cursos/modulosCurso.js"
        ]
    ];
?>