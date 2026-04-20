<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set("America/Mexico_City");

if (isset($_GET['password']) && $_GET['password'] == "ameh") {

    include 'config/config.php';
    require 'core/conexion.php';
    require 'model/helper.php';
    require 'model/alumno.php';

    $H = new Helper();
    $A = new Alumno();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liberar Accesos Plataforma</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css"> -->


        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">

        <!-- Buttons extension -->
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">

    </head>

    <body>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2>Registros</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-right">
                        <!-- <a class="btn btn-success" href="excel2024.php">Excel</a> -->
                        <a class="btn btn-success" href="liberarAcceso_2024.php?password=ameh">Actualizar</a>
                        <a class="btn btn-info" href="becas2.php?password=ameh">Becas</a>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="table-responsive">
                            <table class="table" id="data-ble">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>ID_usuario</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Pais</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Telefono</th>
                                        <th scope="col">Estatus</th>

                                        <th scope="col">Observaciones</th>
                                        <th scope="col">Modulos</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Fecha de Registro</th>
                                        <th scope="col">Fecha de pago</th>



                                        <th scope="col">Datos Fiscales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $alumnos = $A->getAlumnos_2024();
                                    ?>

                                    <?php $a = 1;
                                    $i = 0; ?>
                                    <?php foreach ($alumnos as $al) {
                                        $i++; ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $al->id ?></td>
                                            <td><?= $al->nombre . " " . $al->apellidos ?></td>
                                            <td><?= $al->email ?></td>
                                            <td>
                                                <?= $al->categoria ?>
                                            </td>
                                            <td><?= $al->pais ?></td>
                                            <td><?= $al->estado ?></td>
                                            <td><?= $al->telefono ?></td>

                                            <td>
                                                <?php
                                                if ($al->estatus == "PAGADO" || $al->estatus == "BECADO") {
                                                    echo $al->estatus;
                                                } else {
                                                    echo "Pendiente";
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?= $al->observaciones ?>
                                            </td>
                                            <td>
                                                <?php
                                                $modulos = $A->getModulosPagados($al->id);
                                                $total = 0;
                                                $text_modulos = "";
                                                $separador = "";
                                                foreach ($modulos as $modulo) {
                                                    $total = $total + $al->monto;
                                                    $text_modulos .= $separador . $modulo->modulo;
                                                    $separador = ", ";
                                                }
                                                echo $text_modulos;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($total > 0) {
                                                    echo $total;
                                                } else {
                                                    echo $al->monto;
                                                }
                                                ?>
                                            </td>

                                            <td><?= $al->fecha_registro ?></td>
                                            <td>
                                                <?= $al->fecha_pago ?>
                                            </td>

                                            <td>
                                                <?php if ($al->rfc) { ?>
                                                    <?= "RFC: " . $al->rfc . ", Razon social: " . $al->razon_social . ", CP: " . $al->codigo_postal . ", Estado: " . $al->estadof . ", Uso de CFDI: " . $al->uso_de_cfdi ?>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script> -->

        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

        <!-- Buttons + dependencias para Excel -->
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>

        <script>
            $(document).ready(function() {
                // $('.table').DataTable();


                $('.table').DataTable({
                    // Muestra los botones en la parte superior
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Excel',
                        filename: 'Reporte_AMEH_2026',
                        exportOptions: {
                            modifier: {
                                columns: ':visible'
                            } 
                        }
                    }],
                });


            });
        </script>
    </body>

    </html>
<?php } ?>