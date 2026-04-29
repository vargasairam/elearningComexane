console.log("main_grid.js");

document.addEventListener("DOMContentLoaded", async function() {
    await esperarMasonry();
    await getCursos();
});

function esperarMasonry() {
    return new Promise(resolve => {
        const check = () => {
            if (typeof Masonry !== "undefined") {
                resolve();
            } else {
                setTimeout(check, 50);
            }
        };
        check();
    });
}

async function getCursos() {
    try {
        let res = await fetch("./controller/catalogos.php?accion=GetCursos", {
            method: "GET"
        });
        let response = await res.json();
        if(response.status){
            const path = `${BASE_URL}/imgs/cursos_posters/`;
            response.data.forEach(curso => {
                curso.poster = curso.poster == null ? "Poster.jpg" : curso.poster;
                let html = `<a  href="" target="_blank">
                    <div class="grid-item" data-img="${curso.poster}">
                        <figure>
                            <img id="" class="w-80 rounded-3" src="${path}/${curso.poster}" alt="First slide">
                        </figure>
                        <p id="${curso.titulo}" class="info-titulo my-0 text-center mb-3" style="margin-left: 0px !important; line-height: 17px !important; ">${curso.titulo}</p>
                        <p class="info-curso ms-2 me-2""><strong class="text-info">Costo:</strong> <span>${currency(curso.precio, { symbol: '$', decimal: '.', separator: ',' }).format()}</span></p>
                        <p class="info-curso ms-2 me-2""><strong class="text-info">Descripción:</strong> <span>${curso.descripcion}</span></p>
                        <p class="info-curso ms-2 me-2""><strong class="text-info">Disponible:</strong> <span>${moment(curso.fecha_hora_inicio).format('DD-MM-YYYY')} al ${moment(curso.fecha_hora_fin).format('DD-MM-YYYY')}</span></p>
                        <div class="d-flex justify-content-end gap-2 mb-2 me-2">
                            <button class="btn btn-iconos btn-sm carrito" data-curso-id="${curso.id}" title="Agregar al carrito"><i class="ri-shopping-cart-line"></i> </button>
                           
                        </div>
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
            /*var $msnry = new Masonry(grid, {
                // options
                columnWidth: 35,
                itemSelector: '.grid-item',
                //columnWidth: 100,
                gutter: 10,
                isFitWidth: true,
                originLeft: true
            });*/
        }
    }
    catch (err) {
        console.error("Error en fetch:", err);
    }
}

/*  <button class="btn btn-iconos btn-sm ver-mas" data-curso-id="${curso.id}" title="Ver más"><i class="ri-play-circle-line"></i> </button> */

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


  