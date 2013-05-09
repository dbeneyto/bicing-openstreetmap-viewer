<!DOCTYPE HTML>
<html>
<head>
<title>OpenLayers - OpenStreetMaps - Bicing</title>
</head>
<body>

<?php
try {
  // open connection to MongoDB server
  $conn = new Mongo('localhost');

  // access database
  $db = $conn->bicing;

  // access collection
  $collection = $db->data;

  // execute query
  // retrieve all documents
  $cursor = $collection->find()->limit(400);

  // iterate through the result set
  // print each document
  echo $cursor->count() . ' document(s) found. <br/>';
  $stations=array();
  foreach ($cursor as $obj) {
    $lat=$obj['lat']/1000000;
    $lng=$obj['lng']/1000000;
    $marker=array($lat,$lng);
    array_push($stations,json_encode($marker));
  }

  // disconnect from server
  $conn->close();
} catch (MongoConnectionException $e) {
  die('Error connecting to MongoDB server');
} catch (MongoException $e) {
  die('Error: ' . $e->getMessage());
}
?>

<div id="Map" style="height:800px"></div>
<script src="./lib/OpenLayers.js"></script>
<script>
    // Center Barcelona on the map
    var lat            = 41.405;
    var lon            = 2.185593;
    var zoom           = 13;
 
    var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
    var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
    var position       = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
 
    map = new OpenLayers.Map("Map");
    var mapnik         = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);
 
    map.setCenter(position, zoom);

    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);

    var stations_array_json = <? print json_encode($stations); ?>;

    for (var i = 0; i < stations_array_json.length; i++) {
       var lat = JSON.parse(stations_array_json[i])[0]; 
       var lng = JSON.parse(stations_array_json[i])[1]; 
//       document.write( lat + "<br>" );
       var position = new OpenLayers.LonLat(lng,lat).transform( fromProjection, toProjection);
       markers.addMarker(new OpenLayers.Marker(position));
    }
    
 
</script>
</body>
</html>
