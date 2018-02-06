var tileLayer = new L.TileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
});

var map = new L.Map('map', {
  'center': [46.2276, 2.2137],
  'zoom': 5,
  'layers': [tileLayer]
});

var marker = L.marker([46.2276, 2.2137],{
  draggable: true
}).addTo(map);

marker.on('dragend', function (e) {
  document.getElementById('latitude').value = marker.getLatLng().lat;
  document.getElementById('longitude').value = marker.getLatLng().lng;
}).bindPopup("Drag to wanted city.").openPopup();