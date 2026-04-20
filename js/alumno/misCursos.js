console.log("mmiscursos.js");

document.addEventListener("DOMContentLoaded", async function() {
    await getCursos();

});

async function getCursos() {
    try {
        let res = await fetch("./controller/alumno.php?accion=GetCursos", {
            method: "GET"
        });
        let response = await res.json();
        console.log(response);
        if(response.length > 0){
            const path = `${BASE_URL}/imgs/cursos_posters/`;
            response.forEach(curso => {
                curso.poster = curso.poster == null ? "Poster.jpg" : curso.poster;
                let html = `<a  href="" target="_blank">
                    <div class="grid-item" data-img="${curso.poster}">
                        <figure>
                            <img id="" class="w-80 rounded-4" src="${path}/${curso.poster}" alt="First slide">
                        </figure>
                        <p id="${curso.titulo}" class="info-titulo my-0 text-center mb-3" style="margin-left: 0px !important; line-height: 17px !important; ">${curso.titulo}</p>
                        <p class="info-curso ms-2 me-2""><strong class="text-info">Descripción:</strong> <span>${curso.descripcion}</span></p>
                    </div>
                </a>`;

                $(".grid").append(html);
            });

            var grid = document.querySelector('.grid');
            imagesLoaded(grid, function () {
                new Masonry(grid, {
                    columnWidth: 35,
                    itemSelector: '.grid-item',
                    gutter: 10,
                    isFitWidth: true,
                    originLeft: true
                });
            });
        } else {
            let html = `<div>
               <h1>Aún no has comprado ningún curso</h1><br>
               <a href="${BASE_URL}" class="btn btn-primary">Comprar curso</a>
            </div>`

            $("#mensaje_no_cursos").html(html);
        }
    }
    catch (err) {
        console.error("Error en fetch:", err);
    }
}

$(document).on('click', '.carrito', function(e){
    e.preventDefault();
    let url = `${BASE_URL}/controller/alumno.php?accion=AgregarAlCarrito`;
    let curso_id = $(this).data('curso-id');
    let FORMDATA = new FormData();
    FORMDATA.append('curso_id', curso_id);
    console.log(curso_id);

    fetch(url, {
        method: 'POST',
        body: FORMDATA
    })
    .then(res => res.json()) // Si tu PHP devuelve JSON
    .then(data => {
        if (data.status == 'success') {
            mostrarAviso(data.status, data.msg);
            mostrarProductosEnCarrito();
        } else {
            mostrarAviso(data.status, data.msg);
        }
        
    })
    .catch(err => {
        console.error('Error en el fetch:', err);
        alert('Error de conexión 💀');
    });
});


  