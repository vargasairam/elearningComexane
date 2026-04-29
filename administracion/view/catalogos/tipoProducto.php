<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="row g-6 mt-0">
        <div class="col-xxl mt-3">            
            <div>
                <div class="card-header">
                    <div class="row m-3 my-0 justify-content-between">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto">
                            <button class="btn btn-inicio add-new btn-primary" tabindex="0" aria-controls="tb_empresas" type="button" data-bs-toggle="modal" data-bs-target="#modal_tipoProducto"><span><span class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-plus"></i> <span class="d-none d-sm-inline-block">Agregar</span></span></span></button>
                        </div>
                    </div>                
                </div>
                <div class="card-body">
                    <!-- TABLA EMPRESAS -->
                    <div class="card-datatable">
                        <table id="tb_tipoProducto" class="datatables-users table">
                            <thead class="border-top">
                                <tr>
                                    <th>#</th>
                                    <th>Tipo de producto</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_tipoProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Nueva tipo de producto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="addTipoProducto">
                    <div class="modal-body size-f-modal">
                        <div class="row">
                            <div class="col mb-4">
                                <label class="form-label">Tipo de producto</label>
                                <input type="text" name="tipo_producto" class="form-control" required placeholder="Ingrese tipo de producto">
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col mb-0">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" required></textarea>
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

    <div class="modal fade" id="modal_editarTipoProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Actualizar datos</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="updateTipoProducto">
                    <div class="modal-body size-f-modal">
                        <div class="row">
                            <div class="col mb-4">
                                <label class="form-label">Tipo de producto</label>
                                <input type="text" id="tipo_producto" name="tipo_producto" class="form-control" required placeholder="Ingrese tipo de producto">
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col mb-0">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
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

<?php
    $scripts_js = [
        "js" => [
            //"https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js",
            "js/Catalogos/tipoProducto.js"
        ]
    ];
?>