<?php
    $flecha_back = '<a href="./?seccion=catalogos&accion=cursos" class="btn add-new btn-light" role="button">
        <span class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span class="d-none d-sm-inline-block">Regresar</span>
        </span>
    </a>';
?>

<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="row g-6 mt-0">
        <div class="col-xxl mt-3">            
            <div>
                <div class="card-header">
                    <div class="row m-3 my-0 justify-content-between">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto">
                            <?php echo $flecha_back; ?>
                        </div>

                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto">
                            <button class="btn btn-inicio add-new btn-primary" tabindex="0" aria-controls="tb_empresas" type="button" data-bs-toggle="modal" data-bs-target="#modal_insertar"><span><span class="d-flex align-items-center gap-2"><i class="fas fa-upload"></i> <span class="d-none d-sm-inline-block">Subir video</span></span></span></button>
                        </div>
                    </div>                
                </div>
                <div class="card-body">
                    <!-- TABLA EMPRESAS -->
                    <div class="card-datatable">
                        <table id="tb_videosCurso" class="datatables-users table">
                            <thead class="border-top">
                                <tr>
                                    <th>#</th>
                                    <th>Título del video</th>
                                    <th>Tema</th>
                                    <th>Detalles</th>
                                    <th>Ponentes</th>
                                    <th>Fecha publicación</th>
                                    <th>Duración</th>
                                    <th>Canal 1</th>
                                    <th>Canal 2 (Traducción)</th>
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
                    <h5 class="modal-title" id="exampleModalLabel1">Subir video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="addVideo" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label">Título del video <span class='obligatorio'>*</span></label>
                                <input type="text" name="titulo" class="form-control" required placeholder="Ingrese título del video">
                                <input type="hidden" name="id_curso" value="<?= $id_curso ?>">
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Tema <span class='obligatorio'>*</span></label>
                                <input type="text" name="tema" class="form-control" required placeholder="Ingrese tema del video">
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Detalles <span class='obligatorio'>*</span></label>
                                <textarea name="detalles" class="form-control" required></textarea>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Ponentes <span class='obligatorio'>*</span> <small>Ingresar el nombre de los ponentes separados por comas</small></label>
                                <textarea name="ponentes" class="form-control" required></textarea>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha publicación <span class='obligatorio'>*</span></label>
                                <input type="date" name="f_publicacion" class="form-control" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Duración <small>(En minutos)</small> <span class='obligatorio'>*</span></label>
                                <input type="number" name="duracion" class="form-control" required placeholder="Ingrese duración en minutos">
                            </div>

                            <div class="col-12 mb-4">
                                <small>Para el canal, coloca la URL de Vimeo en el campo correspondiente siguiendo el formato mostrado abajo. Identifica y selecciona la parte resaltada en negritas, ya que corresponde al número del evento: https://vimeo.com/event/<strong>5838757</strong>/embed/interaction</small>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Canal 1 <span class='obligatorio'>*</span></label>
                                <input type="number" name="canal1" class="form-control" required placeholder="Ingrese canal">
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Canal 2 (Traducción) </label>
                                <input type="number" name="canal2" class="form-control" placeholder="Ingrese canal (Traducción)">
                            </div>

                            <div class="col-8 mb-4">
                                <label class="form-label">Portada del video <span class='obligatorio'>*</span><small>(Debe ser una imagen .jpg, .png o .jpeg)</small></label>
                                <input type="file" name="portada" class="form-control" placeholder="Ingrese la portada del video" accept=".jpg,.png,.jpeg" required>
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
                <form class="add-new-user pt-0" id="updateVideo">
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label">Título del video <span class='obligatorio'>*</span></label>
                                <input type="text" id="titulo" name="titulo" class="form-control" required placeholder="Ingrese título del video">
                                <input type="hidden" name="id_curso" value="<?= $id_curso ?>">
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Tema <span class='obligatorio'>*</span></label>
                                <input type="text" id="tema" name="tema" class="form-control" required placeholder="Ingrese tema del video">
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Detalles <span class='obligatorio'>*</span></label>
                                <textarea id="detalles" name="detalles" class="form-control" required></textarea>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Ponentes <span class='obligatorio'>*</span> <small>Ingresar el nombre de los ponentes separados por comas</small></label>
                                <textarea id="ponentes" name="ponentes" class="form-control" required></textarea>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha publicación <span class='obligatorio'>*</span></label>
                                <input type="date" id="f_publicacion" name="f_publicacion" class="form-control" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Duración <small>(En minutos)</small> <span class='obligatorio'>*</span></label>
                                <input type="number" id="duracion" name="duracion" class="form-control" required placeholder="Ingrese duración en minutos">
                            </div>

                            <div class="col-12 mb-4">
                                <small>Para el canal, coloca la URL de Vimeo en el campo correspondiente siguiendo el formato mostrado abajo. Identifica y selecciona la parte resaltada en negritas, ya que corresponde al número del evento: https://vimeo.com/event/<strong>5838757</strong>/embed/interaction</small>
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Canal 1 <span class='obligatorio'>*</span></label>
                                <input type="number" id="canal1" name="canal1" class="form-control" required placeholder="Ingrese canal">
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label">Canal 2 (Traducción) </label>
                                <input type="number" id="canal2" name="canal2" class="form-control" placeholder="Ingrese canal (Traducción)">
                            </div>

                            <div class="col-8 mb-4">
                                <label class="form-label">Portada del video <small>(Debe ser una imagen .jpg, .png o .jpeg)</small></label>
                                <input type="file" name="portada" class="form-control" placeholder="Ingrese la portada del video" accept=".jpg,.png,.jpeg">
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

    <!-- MODAL PARA VER LA IMAGEN DEL VIDEO -->
    <div class="modal fade" id="modalImagen" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 position-relative">            
                <!-- BOTÓN CERRAR -->
                <button type="button" 
                    class="btn-close btn-close-white position-absolute top-0 end-0 m-0"
                    style="z-index: 1055;"
                    data-bs-dismiss="modal">
                </button>

                <div class="modal-body text-center">
                <div id="div_imagen"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA VER VIDEO -->
    <div class="modal fade" id="verVideo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">        
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Vista previa video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="video_preview" style="padding:48.02% 0 0 0;position:relative;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <div class="item_curso">
    <a href="?seccion=ondemand&amp;accion=recording&amp;modulo=1&amp;id=1">
        <img class="picture_curso thumb_1" src="https://curso-ameh.com/imgs/2026/Módulo 1_1.png" alt="">
    </a>

    <div class="info_curso">
        <div class="progress" role="progressbar" aria-label="Progreso de visualización" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-warning" style="width: 44%">44%</div>
        </div>
        
        <h5 class="mt-1">Anemias carenciales adultos</h5>

        <div class="text-muted d-flex justify-content-between w-100 gap-1">
            <small>                
                <i class="ri-user-fill"></i> Dr. José L. Alvarez Vera
            </small>
      
            <small> <i class="ri-time-fill"></i>
                0:32
            </small>
        </div>

        <div class="text-muted d-flex justify-content-between w-100 gap-1">
            <small>06 de febrero</small>
        </div>

        <hr>
        <a class="c_primary d-block w-100 text-center btn btn-primary" href="?seccion=ondemand&amp;accion=recording&amp;modulo=1&amp;id=1">Ver video</a>
    </div>
</div> -->

<?php
    $scripts_js = [
        "js" => [
            //"https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js",
            "js/Cursos/videosCurso.js"
        ]
    ];
?>