var serie = document.getElementById("mapSerie");
var photo = document.getElementById("mapPhoto");

if(serie){
  var tileLayerSerie = new L.TileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
  });

  var mapSerie = new L.Map('mapSerie', {
    'center': [46.2276, 2.2137],
    'zoom': 5,
    'layers': [tileLayerSerie]
  });

  var markerSerie = L.marker([46.2276, 2.2137],{
    draggable: true
  }).addTo(mapSerie);

  markerSerie.on('dragend', function (e) {
    document.getElementById('latitude').value = markerSerie.getLatLng().lat;
    document.getElementById('longitude').value = markerSerie.getLatLng().lng;
  }).bindPopup("Drag to wanted city.").openPopup();
}

if(photo) {
  var tileLayerPhoto = new L.TileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
  });
  
  var mapPhoto = new L.Map('mapPhoto', {
    'center': [46.2276, 2.2137],
    'zoom': 16,
    'layers': [tileLayerPhoto]
  });
  
  var markerPhoto = L.marker([latitude, longitude],{
    draggable: true
  }).addTo(mapPhoto);
  
  markerPhoto.on('dragend', function (e) {
    document.getElementById('latitude').value = markerPhoto.getLatLng().lat;
    document.getElementById('longitude').value = markerPhoto.getLatLng().lng;
  }).bindPopup("Drag to photo location.").openPopup();
}

