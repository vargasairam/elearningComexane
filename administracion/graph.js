document.addEventListener("DOMContentLoaded", function() {
    const $grafica = document.querySelector("#grafica");
    const datosPHP = <?php echo json_encode($datos); ?>; // Convertir datos PHP a JSON

    // Las etiquetas son las que van en el eje X.
    const etiquetas = datosPHP.map(dato => dato.etiqueta);
    
    // Los valores son los que van en el eje Y.
    const valores = datosPHP.map(dato => dato.valor);

    const datosVentas2020 = {
        label: "Ventas por mes",
        data: valores,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
    };

    var chart = new Chart($grafica, {
        type: 'bar',
        data: {
            labels: etiquetas,
            datasets: [
                datosVentas2020,
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
            },
        }
    });
});