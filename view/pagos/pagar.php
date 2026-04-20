
<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="content_dashboard">
    <div class="drawer_ttl_pleca d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-start align-items-md-center gap-4">
        <div>
            <h3 class="mb-1" style="color: white;">Resumen de la compra</span></h3>
        </div>
    </div>
    <div class="col-12 mt-3" bis_skin_checked="1">
        <div class="card shadow-sm border-0 rounded-4">
            <form id="form-pagar" enctype="multipart/form-data">
                <div id="resumen_compra" class="card-body p-3"></div>    
                <div class="card-body p-3">
                    <!-- Total -->
                    <div id="total_pagar" class="d-flex justify-content-between align-items-center mt-4">
                        <h5 class="fw-bold mb-0">Total</h5>
                    </div>

                    <div id="btn_proceder_pago" class="mt-4">
                        <button type="submit" class="btn btn-iconos w-100 py-2 fw-bold">
                            Proceder al pago
                        </button>
                    </div>     
                </div>   
            </form>
        </div>
    </div>
</section>


<?php
    $scripts_js = [
        "js" => [
            "js/alumno/pagar.js"
        ]
    ];
?>
