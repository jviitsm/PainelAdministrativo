var map;
var idInfoBoxAberto;
var infoBox = [];
var markers = [];

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

function abrirInfoBox(id, marker) {
    if (typeof(idInfoBoxAberto) == 'number' && typeof(infoBox[idInfoBoxAberto]) == 'object') {
        infoBox[idInfoBoxAberto].close();
    }

    infoBox[id].open(map, marker);
    idInfoBoxAberto = id;
}

function carregarPontos() {

    $.getJSON('http://servico.projetocitycare.com.br/denuncia/er', function(pontos) {

        var latlngbounds = new google.maps.LatLngBounds();

        $.each(pontos, function(index, ponto) {

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(ponto.latitude_denuncia, ponto.longitude_denuncia),
                title: "Denuncia",

            });

            var myOptions = {
                content: "<p>" + "Categoria: " + ponto.fk_categoria_denuncia.descricao_categoria
                + ". Descricao: " + ponto.descricao_denuncia + ponto.descricao_denuncia + "</p>",
                pixelOffset: new google.maps.Size(-150, 0)
            };

            infoBox[ponto.id_denuncia] = new InfoBox(myOptions);
            infoBox[ponto.id_denuncia].marker = marker;

            infoBox[ponto.id_denuncia].listener = google.maps.event.addListener(marker, 'click', function (e) {
                abrirInfoBox(ponto.id_denuncia, marker);
            });

            markers.push(marker);

            latlngbounds.extend(marker.position);

        });

        var markerCluster = new MarkerClusterer(map, markers);

        map.fitBounds(latlngbounds);

    });

}

carregarPontos();