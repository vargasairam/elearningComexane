<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir PDF</title>
</head>

<body>
    <h2>Subir archivo PDF</h2>
    <form action="redireccionPDF.php?recurso=uploadFile" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" accept="application/pdf" required>
        <button type="submit">Subir PDF</button>
    </form>
</body>

</html>