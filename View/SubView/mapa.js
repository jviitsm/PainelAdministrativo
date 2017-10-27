var map;

function initialize() {
    var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);

    var options = {
        zoom: 5,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
}

initialize();


function carregarPontos() {



    var jsonResult = "http://servico.projetocitycare.com.br/denuncia/er";


    $.getJSON("http://servico.projetocitycare.com.br/denuncia/er", function(pontos) {

        $.each(pontos, function(index, ponto) {

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(ponto.latitude_denuncia, ponto.longitude_denuncia),
                title: "Meu ponto personalizado! :-D",
                map: map
            });

        });

    });

}

carregarPontos();