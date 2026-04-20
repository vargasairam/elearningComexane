var avance=0;
               
                var iframe = document.getElementById('video-v');
                var player = new Vimeo.Player(iframe);
                if ($("#seconds").val()=="0") {
                    var segundos=1;
                }else{
                    var segundos=(parseInt($("#seconds").val()))-10;
                }

                player.on('play', function() {
                    console.log('Reproduciendo video ONDEMAND');
                    startVimeo();
                });

                function startVimeo(){
                    var avance=0;
            var iframe = document.getElementById('video-v');
            var player = new Vimeo.Player(iframe);
            var segundos=($("#seconds").val())-10;
            if(segundos>0){
            }

            player.on('ended', function(data) {
                marcarVideo();
            });
            player.on('ended', function(data) {
                marcarVideo();
            });

            player.on('timeupdate', function(data) {
                if(Math.round(data.seconds)>avance){
                    avance=Math.round(data.seconds);
                    if(avance%60==0){
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
                data: {accion:"sumartiempo", modulo_id: modulo_id, usuario_id:user},
            })
            .done(function(response) {
                console.log(response);
            })
            .always(function() {
                setTimeout(
                    function(){                        
                        sumarTiempo (modulo_id);
                    }, 60000);
            });
        }
