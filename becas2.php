<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set ("America/Mexico_City");

if (isset($_GET['password']) && $_GET['password']=="ameh") {

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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">


    </head>
    <body>

     <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Aceptados</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                     <a class="btn btn-success" href="liberarAcceso_2024.php?password=ameh">Regresar</a>
                    <a class="btn btn-success" href="becas2.php?password=ameh">Actualizar</a>
                </div>
                <div class="col-12 mt-2">
                    <div class="table-responsive">
                        <table class="table" id="data-ble">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre completo</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Año</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $alumnos = $A->becas2024(); ?>
                                <?php $a = 1;
                                $i = 0; ?>
                                <?php foreach($alumnos as $al) { $i++; ?>
                                    <tr>
                                        <td  ><?= $i ?></td>
                                        <td><?= $al->nombre." ".$al->apellidop. " ". $al->apellidom ?></td>
                                        <td><?= $al->email ?></td>
                                        <td><?= $al->ano ?></td>
                                        <td><?= $al->codigo ?></td>
                                        <td><? 
                                        $v = $A->ver($al->codigo);
                                        if($v){
                                             echo '<span style="color: green;"> USADO</span> <br>';
                                        }else{

                                        } ?>
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('.table').DataTable();
        } );
    </script>
</body>
</html>
<?php } ?>