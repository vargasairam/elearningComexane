const iframe = document.getElementById('video-v');
const player = new Vimeo.Player(iframe);

let avance = 0;
let ultimoMinuto = 0;

// SOLO una vez
player.on('timeupdate', function(data) {
    const segundosActuales = Math.floor(data.seconds);

    if (segundosActuales > avance) {
        avance = segundosActuales;

        // cada minuto exacto
        if (avance % 60 === 0 && avance !== ultimoMinuto) {
            ultimoMinuto = avance;
            sumarMinuto();
        }
    }


});

player.on('ended', function() {
    marcarVideo();
});

// opcional: detectar play
player.on('play', function() {
    console.log('Reproduciendo video ONDEMAND');
});

function sumarMinuto () {
    console.log("sumar minuto");
    $.ajax({
        url: 'controller/transmisiones.php?accion=addminutoVideo',
        type: 'POST',
        dataType: 'json',
        data: {
            //accion: "addminutoVideo", 
            video_id: videoId, 
            usuario_id: user
        },
    })
    .done(function(response) {
    });
}


/*var avance=0;
               
let iframe = document.getElementById('video-v');
let player = new Vimeo.Player(iframe);

if($("#seconds").val()=="0") {
    let segundos = 1;
} else {
    let segundos=(parseInt($("#seconds").val()))-10;
}

player.on('play', function() {
    console.log('Reproduciendo video ONDEMAND');
    startVimeo();
});

function startVimeo(){
    //var avance=0;
    //var iframe = document.getElementById('video-v');
    //var player = new Vimeo.Player(iframe);
    segundos = ($("#seconds").val())-10;
    if(segundos > 0){}

    player.on('ended', function(data) {
        marcarVideo();
    });

    player.on('ended', function(data) {
        marcarVideo();
    });

    player.on('timeupdate', function(data) {
        if(Math.round(data.seconds) > avance){
            avance = Math.round(data.seconds);
            if(avance % 60 == 0){
                sumarMinuto();
            }
        }
    });
}

function sumarMinuto () {
    console.log("sumar minuto");
    $.ajax({
        url: 'controller/transmisiones.php',
        type: 'get',
        dataType: 'json',
        data: {accion:"addminutoVideo", video_id: videoId, usuario_id:user},
    })
    .done(function(response) {
    });
}

function marcarVideo () {
    // var video=$("#video_reproduciendo").val();
    $.ajax({
        url: 'controller/transmisiones.php',
        type: 'get',
        dataType: 'json',
        data: {accion:"ended", video_id: videoId, usuario_id:user},
    })
    .done(function(response) {
    });
}

function sumarTiempo (modulo_id) {
    $.ajax({
        url: 'controller/transmisiones.php',
        type: 'get',
        dataType: 'json',
        data: {
            accion: "sumartiempo", 
            modulo_id: modulo_id, 
            usuario_id : user
        },
    }).done(function(response) {
        console.log(response);
    }).always(function() {
        setTimeout(
        function(){                        
            sumarTiempo (modulo_id);
        }, 60000);
    });
}*/
