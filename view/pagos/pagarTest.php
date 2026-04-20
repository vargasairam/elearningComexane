<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 <div class="page-content-inner">

     <!-- <h2> Costos </h2> -->


     <ul class="uk-subnav pricing-swicher " uk-switcher="connect: #change-plan ;animation: uk-animation-slide-top-medium, uk-animation-scale-up">
         <h2 class="mt-3">Costo</h2>
         <!-- <li><a href="#">Yearly <span>Save 10%</span> </a></li> -->
     </ul>
     <center>
         <!--<p class="text-primary">Realiza tu pago con depósito o transferencia bancaria y envia tu comprobante al correo <a href="mailto:<?php echo sociedad_email_administracion; ?>?subject=Envio de comprobante para acceso al Curso de Actualización en Hematología para Residentes 2022" style="color: red" ><b><?php echo sociedad_email_administracion; ?></b></a></p>
    <p class="text-primary">O si lo deseas puedes pagar con PayPal y desbloquea el acceso inmediatamente</p>-->
         <p class="text-red">
             <!-- <a href="./?seccion=perfil&accion=editar" style="color: red" title=""> <b>Si requieres factura, envia tus datos fiscales al siguiente correo: hola@amehac.org</b></a> -->
             <a href="./?seccion=perfil&accion=editar" style="color: red" title=""> <b>Este es un test al siguiente correo: hola@amehac.org</b></a>
         </p>
         <div class="uk-width-auto@s"><a href="./?seccion=perfil&accion=editar" style="color: red" title="">
                 <input type="submit" class="btn btn-primary btn-lg " value="Registra tus Datos">&nbsp;&nbsp;&nbsp;
             </a>
         </div>
     </center>
     <!-- Pricing Plans Container -->
     <?php
        $mensaje = $H->verMensaje();
        if (isset($mensaje['texto']) && $mensaje['texto'] != "") {
        ?>

         <div class="uk-alert-success" uk-alert>
             <a class="uk-alert-close" uk-close></a>
             <center>
                 <p><?= $mensaje['texto'] ?></p>
             </center>
             <p class="text-center">Si deseas obtener más información sobre las inscripciones, envianos un correo a: hola@amehac.org</p>
         </div>

     <?php
        }
        ?>
     <div class="pricing-plans-container">
         <!-- Publico -->
         <div class="pricing-plan recommended">
             <?php if ($alumno->categoria_id != 5) { ?>
                 <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="controller/alumno.php?accion=becar">
                     <div class="uk-width-3-5@s">
                         <label class="uk-form-label"> Si tienes beca ingresa el código aquí</label>
                         <div class="uk-position-relative w-100">
                             <input id="beca" type="text" class="uk-input uk-form-small" name="beca" placeholder="XXXXXX" required>
                         </div>
                     </div>
                     <div class="uk-width-2-5@s">
                         <div class="mt-3 uk-flex-middle uk-grid-small" uk-grid>
                             <div class="uk-width-2-5@s">
                                 <!-- <input type="text" name="codigodescuento" id=""> -->
                             </div>
                             <div class="uk-width-auto@s">
                                 <input type="submit" class="btn btn-primary btn-lg " value="Aplicar Beca">&nbsp;&nbsp;&nbsp;
                             </div>
                         </div>
                     </div>
                     <input type="hidden" name="alumno" value="<?php echo $alumno->id; ?>">
                 </form>

             <?php } ?>
             <?php if ($alumno->categoria_id == 5) { ?>
                 <form method="post" action="controller/alumno.php?accion=actualizarC" class="uk-child-width-1-1 uk-grid-small">
                     </br></br>
                     <input type="hidden" name="id" value="<?php echo $alumno->id ?>">
                     <div class="uk-width-3-5@s">
                         <label class="uk-form-label"> Categoría</label>
                         <label for="categoria">Si desea cambiar de categoria seleccione aquí:</label>
                         <div class="uk-position-relative w-100">
                             <select id="categoria" class="uk-input uk-form-small" name="categoria" required>
                                 <?php $categorias = $H->getCategorias(); ?>
                                 <option value="">Seleccionar categoría</option>
                                 <?php foreach ($categorias as $categoria) { ?>
                                     <option value="<?php echo $categoria->id ?>"><?php echo $categoria->categoria ?></option>
                                 <?php } ?>
                             </select>
                         </div>
                     </div>
                     <div class="uk-width-2-5@s">
                         <div class="uk-width-auto@s">
                             <input type="submit" class="btn btn-default" value="Actualizar"></input>
                         </div>
                     </div>
                 </form>
                 <label for="uk-form-label">Si ya pagaste un módulo espera el día y la hora de esté para que lo puedas visualizar</label>
                 <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="controller/alumno.php?accion=modulo">
                     <div class="uk-width-1-2@s">
                         <div class="uk-form-group">
                             <label class="uk-form-label"> Módulo</label>
                             <div class="uk-position-relative w-100">
                                 <select id="categoria" class="uk-input uk-form-small" name="modulo" required>
                                     <option value="">Seleccionar módulo</option>
                                     <option value="1">Módulo I. Hematología Benigna</option>
                                     <option value="2">Módulo II. Hemostasia y trombosis</option>
                                     <option value="3">Módulo III. Hematología maligna</option>
                                     <option value="4">Módulo IV. Medicina transfusional y trasplante</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="uk-width-2-5@s">
                         <div class="mt-3 uk-flex-middle uk-grid-small" uk-grid>
                             <div class="uk-width-2-5@s">
                                 <!-- <input type="text" name="codigodescuento" id=""> -->
                             </div>
                             <div class="uk-width-auto@s">
                                 <input type="submit" class="btn btn-primary btn-lg " value="Aplicar Módulo">&nbsp;&nbsp;&nbsp;
                             </div>
                         </div>
                     </div>
                     <input type="hidden" name="alumno" value="<?php echo $alumno->id; ?>">
                 </form>
                 <div class="uk-width-5-5@s">
                    <table class="table" >
                         <thead>
                             <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Módulo</th>
                                 <th scope="col">Estatus</th>
                                 <th scope="col">Título</th>
                                 <th scope="col"></th>
                             </tr>
                         </thead>
                         <tbody >
                             <?php $mID = $H->mID($alumno->id); ?>
                             <?php foreach ($mID as $m) { ?>
                                <tr data-modulo="<?php echo $m->modulo; ?>">
                                    <th scope="row">1</th>
                                    <td><?php echo $m->modulo ?></td>
                                    <td><?php echo $m->status ?></td>
                                    <td><?php
                                        if ($m->modulo == 1) {
                                            echo "Hematología Benigna: Coordina";
                                        } elseif ($m->modulo == 2) {
                                            echo "Hemostasia y trombosis";
                                        } elseif ($m->modulo == 3) {
                                            echo "Hematología maligna";
                                        } elseif ($m->modulo == 4) {
                                            echo "Medicina transfusional y trasplante";
                                        }
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($m->status == 'PAGADO') { ?>
                                            <button class="btn btn-primary btn-lg" id="vivo_<?php echo $m->modulo; ?>" style="display:none;" onclick="redirigirAStreaming()">Ver en vivo </br> AQUÍ</button>
                                            <button class="btn btn-secondary btn-lg" id="concluido_<?php echo $m->modulo; ?>" style="display:none;">Módulo Concluido</button>
                                            <button class="btn btn-secondary btn-lg" id="espera_<?php echo $m->modulo; ?>" style="display:none;">¡Espere un momento! <br>
                                                        En cuanto inicie el módulo, se habilitara el botón para que pueda ingresar al <br>
                                                        En vivo aquí.
                                            </button>
                                            <script>
                                                 function redirigirAStreaming() {
                                                    window.location.href = 'https://curso-ameh.com/?seccion=streaming';
                                                }
                                                $(document).ready(function() {
                                                    /* console.log('<?php echo $m->fecha_hr_inicio ?>'); */
                                                    var fechaInicio = new Date("<?php echo $m->fecha_hr_inicio ?>");
                                                    var fechaFin = new Date("<?php echo $m->fecha_hr_fin ?>");
                                                    
                                                    
                                                    function actualizarBoton() {
                                                        var horaActual = new Date();
                                                        horaActual.setSeconds(0, 0);
                                                        fechaInicio.setSeconds(0, 0);
                                                        fechaFin.setSeconds(0, 0);
                                                        /* console.log(horaActual);
                                                        console.log(fechaInicio); */
                                                        if (horaActual >= fechaInicio  && horaActual <= fechaFin) {
                                                            console.log("HR1");
                                                            if(horaActual >= fechaInicio){
                                                                console.log("HR");
                                                                $("#vivo_<?php echo $m->modulo; ?>").show();
                                                                $("#concluido_<?php echo $m->modulo; ?>").hide();
                                                                $("#espera_<?php echo $m->modulo; ?>").hide();
                                                            }else if (horaActual <= fechaFin) {
                                                                console.log("termino");
                                                                $("#vivo_<?php echo $m->modulo; ?>").hide();
                                                                $("#concluido_<?php echo $m->modulo; ?>").show();
                                                                $("#espera_<?php echo $m->modulo; ?>").hide();
                                                            }
                                                        }else if (horaActual >= fechaFin) {
                                                            console.log("termino");
                                                            $("#vivo_<?php echo $m->modulo; ?>").hide();
                                                            $("#espera_<?php echo $m->modulo; ?>").hide();
                                                            $("#concluido_<?php echo $m->modulo; ?>").show();
                                                        }else {
                                                            console.log("rec");

                                                            $("#vivo_<?php echo $m->modulo; ?>").hide();
                                                            $("#concluido_<?php echo $m->modulo; ?>").hide();
                                                            $("#espera_<?php echo $m->modulo; ?>").show();
                                                            var tiempoRestante = fechaInicio - horaActual;
                                                            setTimeout(actualizarBoton, 60000);
                                                        }
                                                    }
                                                    actualizarBoton();
                                                });
                                            </script>
                                        <?php } else { ?>
                                            <a href="https://curso-ameh.com/?seccion=check&mod=<?php echo $m->modulo ?>" style="color: red; text-decoration: underline;">Da click aquí para seguir con el pago</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                         </tbody>
                     </table>
                 </div>
             <?php include 'checkout.php';
                }elseif($alumno->email == "melissalemus83@hotmcom"){
                    include 'checkout.php';
                } else {
                    if ($pagado == "0") {
                        include 'checkout.php';
                    }
                } ?>
             <!-- <?php if ($alumno->categoria_id == 4) { ?>
    <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="./?seccion=paypal&categoria=<?php echo $alumno->categoria; ?>&ttl=<?php echo base64_encode($alumno->costo); ?>" >
        <div class="uk-width-3-5@s">
            <label class="uk-form-label">Si tiene código de descuento, favor de ingresarlo.</label>
            <div class="uk-position-relative w-100">
                <input id="codigodescuento" type="text" class="uk-input uk-form-small" name="codigodescuento"  placeholder="XXXXXX" required>
            </div>
        </div>

        <div class="uk-width-2-5@s">
            <div class="mt-3 uk-flex-middle uk-grid-small" uk-grid>
                <div class="uk-width-auto@s">
                    <input type="submit" class="btn btn-primary btn-lg " value="Aplicar Descuento">&nbsp;&nbsp;&nbsp;
                </div>
            </div>

        </div>
        <input type="hidden" name="alumno" value="<?php echo $alumno->id; ?>">
    </form>
    <?php } ?> -->

             <!-- <div class="recommended-badge" style="background-color: #003973;">Categoria: <?php echo $alumno->categoria; ?></div>
    <ul class="uk-switcher" id="change-plan">
        <li>
            <div class="pricing-plan-label">Realiza el pago por: <strong>$<?php echo $alumno->costo; ?> <small>(IVA incluido)</small></strong></div>
        </li>
    </ul>

    <div class="pricing-plan-features">
        <h3 class="text-center">Realiza el pago por depósito o transferencia</h3>
        <p class="text-center">
            BANCOMER <br>
            Cuenta  0148834814 <br>
            Clabe 012180001488348149<br>
            Agrupación Mexicana para el Estudio de la Hematología, A.C. 
        </p>

    </div> -->
             <!-- <hr/>
    <center>
        <h3>Realiza el pago con tarjeta de crédito o débito</h3>
        <a href="./?seccion=paypal&categoria=<?php echo $alumno->categoria; ?>&ttl=<?php echo ($alumno->costo); ?>" target="_blank">
            <img src="https://www.paypalobjects.com/marketing/web/mx/logos-buttons/Paga-con-yellow_227x44.png" alt="Check out with PayPal" /></a>
        </center>
    </div> -->


         </div>
         <!-- <center><img src="https://www.paypalobjects.com/marketing/web/mx/logos-buttons/tarjetas.png" alt="Check out with PayPal" /></center>
 -->
     </div>
     <script>
        function cargarTabla() {
            $.ajax({
                url: 'controller/modelos.php?id=' + <?php echo $alumno->id; ?>,
                type: 'GET',
                dataType: 'html',
                success: function(data) {
                    console.log(data);
                    $('#tabla-datos').html(data);
                },
                error: function(error) {
                    console.error('Error al obtener los datos: ', error);
                }
            });
        }
        cargarTabla();
     </script>