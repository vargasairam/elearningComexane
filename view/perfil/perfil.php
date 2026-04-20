
<script> let user = <?= isset($user) ? json_encode($user) : 'null'; ?>;
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
                            <input type="text" class="form-control" required id="Password" disabled value='<?= $user->contrasena ?>'  name="password" placeholder="Password" />
                            <label for="floatingInput">Contraseña</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="cards mb-5">
            <form id='datos_personales' name='datos_personales' method="POST" action="./controller/perfil.php?accion=ActualizarPerfilDatosPersonales" class="">
                <div class="d-flex gap-2 justify-content-between">
                    <h5 class="">Datos personales</h5>
                    <div>
                        <a id='btn_edit2' class="btn btn-warning btn-sm btn_edit">
                            <span>Modificar</span>
                            <i class="ri-pencil-line"></i></a>
                        <button
                            type="submit"
                            id='btnSaveAcceso2' 
                            class="btn btn-primary btn-sm d-none btn_save_info">
                            <span>Guardar</span> <i class="ri-save-line"></i>
                        </button>
                    </div>
                </div>
                <hr />

                <div class="row gx-4 gy-4">
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="Nombres" disabled value='<?= $user->nombre ?>' name="nombre" placeholder="Nombres(s)"
                                        oninput="this.value = this.value.toUpperCase()" required />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="Apellidop" disabled value='<?= $user->apellidop ?>' name="apellidop" placeholder="Apellido paterno"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Apellido paterno</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="Apellidom" disabled value='<?= $user->apellidom ?>' name="apellidom" placeholder="Apellido materno"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Apellido materno</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-floating">
                            <select class="form-select" id="prefijos" name="prefijo" disabled aria-label="Prefijo">
                                <option value="" selected disabled>Título</option> 
                                <option value="DR.">DR.</option>
                                <option value="DRA.">DRA.</option>
                                <option value="ENFERMERA(O)">ENFERMERA(O)</option>
                                <option value="ESTUDIANTE">ESTUDIANTE</option>
                            </select>
                        </div>
                        <div class="form-floating d-none" id="prefijo2div">
                            <input type="text" class="form-control" id="prefijo2" name="prefijo2" placeholder="Especificar prefijo"
                                oninput="this.value = this.value.toUpperCase()" />
                            <label for="floatingInput">Especificar prefijo</label>
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="n_constancia" disabled value='<?= $user->nombreconstancia ?>' name="n_constancia" placeholder="Nombre en constancia"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Nombre en constancia</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-floating">
                            <input type="date" class="form-control" disabled value='<?= $user->f_nacimiento ?>' id="f_nacimiento" name="f_nacimiento" placeholder="Fecha nacimiento" />
                            <label for="floatingInput">Fecha nacimiento</label>
                        </div>
                    </div>                    
                    
                    <div class="col-sm-6">
                        <div class="form-floating">
                            <input type="text" required class="form-control" disabled value='<?= $user->celular ?>' id="Telefono" name="telefono" placeholder="Teléfono" />
                            <label for="floatingInput">Teléfono</label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" disabled value='<?= $user->curp ?>' id="curp" name="curp" placeholder="CURP" />
                            <label for="floatingInput">CURP</label>
                        </div>
                    </div>  

                    <div class="col-sm-4">
                        <div class="form-floating">
                            <select class="form-select" required id="Categoria" disabled name="categoria" aria-label="categoria">
                                        <option value="" disabled selected>Seleccionar una categoria</option>
                                    </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="cards mb-5">
            <form id='datos_ubicacion' name='datos_ubicacion' method="POST" action="./controller/perfil.php?accion=ActualizarPerfilDatosUbicacion" class="">
                <div class="d-flex gap-2 justify-content-between">
                    <h5 class="">Datos ubicación</h5>
                    <div>
                        <a id='btn_edit3' class="btn btn-warning btn-sm btn_edit">
                            <span>Modificar</span>
                            <i class="ri-pencil-line"></i></a>
                        <button
                            type="submit"
                            id='btnSaveAcceso3' 
                            class="btn btn-primary btn-sm d-none btn_save_info">
                            <span>Guardar</span> <i class="ri-save-line"></i>
                        </button>
                    </div>
                </div>
                <hr />

                <div class="row gx-4 gy-4">
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="calle" disabled value='<?= $user->calle ?>' name="calle" placeholder="Calle"
                                        oninput="this.value = this.value.toUpperCase()" required />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="interior" disabled value='<?= $user->numint ?>' name="interior" placeholder="Número interior"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Número interior</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="exterior" disabled value='<?= $user->numext ?>' name="exterior" placeholder="Número exterior"
                                        oninput="this.value = this.value.toUpperCase()" />
                            <label for="floatingInput">Número exterior</label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="colonia" disabled value='<?= $user->colonia ?>' name="colonia" placeholder="Colonia"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Colonia</label>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="municipio" disabled value='<?= $user->delomun ?>' name="municipio" placeholder="Municipio/Delegación"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Municipio/Delegación</label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="cp" disabled value='<?= $user->cp ?>' name="cp" placeholder="Código Postal"
                                        oninput="this.value = this.value.toUpperCase()" required />
                            <label for="floatingInput">Código Postal</label>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-floating">
                            <select class="form-select" required id="Estado" disabled name="estado" aria-label="Estado"></select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="cards">
            <form id='datos_facturacion' name='datos_facturacion' method="POST" enctype="multipart/form-data" action="./controller/facturacion.php?accion=GuardarFacturacion" class="">
                <div class="d-flex gap-2 justify-content-between">
                    <h5 class="">Datos de facturación</h5>
                </div>
                <hr />
                <div class="row g-3 p-4">
                    <a href="https://comexane.com/socios/?seccion=socios&accion=datosfacturacion&id=<?= $user->id_socio ?>" class="btn btn-iconos">Actualizar datos de facturación</a>
                    
                </div>
            </form>
        </div>
    </div>
</section>


    <script src="js/perfil.js"></script>

    