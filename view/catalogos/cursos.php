<?php  
    if($user->requiere_factura){
        

        $datosFacturacion =  $F->GetFacturaUsuario($id);
    }

?>
<script> let user = <?= isset($user) ? json_encode($user) : 'null'; ?>;
    let userFactruacion = <?= isset($datosFacturacion) ? json_encode($datosFacturacion) : 'null'; ?>;
</script>

<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="content_profile">
        <div class="cards mb-5">
            <form id='datos_acceso' name='datos_acceso' action="./controller/perfil.php?accion=ActualizarPerfilAcceso" method="POST" class="form_login">
                <div class="d-flex gap-2 justify-content-between">
                    <h5 class="">Datos de acceso</h5>
                    <div>
                        <a id='btn_edit1' class="btn btn-warning btn-sm btn_edit">
                            <span>Modificar</span>
                            <i class="ri-pencil-line"></i></a>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm d-none btn_save_info"
                            id='btnSaveAcceso1' 
                            >
                            <span>Guardar</span> <i class="ri-save-line"></i>
                        </button>
                    </div>
                </div>
                <hr />
                <div class="row gx-4 gy-5">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" required id="Correo" name="email"
                                        placeholder="Correo electrónico" value='<?= $user->email ?>' disabled/>
                            <label for="floatingInput">Correo electrónico</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" required id="Password" disabled value='<?= $user->password ?>'  name="password" placeholder="Password" />
                            <label for="floatingInput">Contraseña</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

    