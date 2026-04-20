const contenedorQR = document.getElementById('contenedorQR');
const form = document.getElementById('qr2');
const va = document.getElementById('link');

const QR = new QRCode(contenedorQR);

document.getElementById('qr2').addEventListener('click', function () {
    try {
        var valor = document.getElementById('link').value;
        console.log('Valor del input:', valor);
        var url = "controllers/encuesta.php?accion=qr&id=" + valor;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (valor.trim() !== '') {
                    QR.makeCode(valor);

                    html2canvas(document.getElementById('contenedorQR'), {
                        onrendered: function(canvas) {
                            var imgData = canvas.toDataURL('image/png');
                            var link = document.createElement('a');
                            link.href = imgData;
                            link.download = 'codigo_qr.png';
                            link.click();
                        }
                    });
                } else {
                    console.error('El valor del input está vacío.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } catch (error) {
        console.error('Error al generar el código QR:', error);
    }
});