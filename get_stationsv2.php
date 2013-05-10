<?php

  // open connection to MongoDB server
  $conn = new Mongo('localhost');

  // access database
  $db = $conn->bicing;

  // access collection
  $collection = $db->data;

//header("Content-type: text/json");

  $last_element = $collection->find()->sort(array('_id' => -1))->limit(1);

  foreach ($last_element as $obj) {
     $last_timestamp=$obj['timestamp']->sec;
  }
  $mongotime = New Mongodate($last_timestamp);
  $collectionQuery=array('timestamp'=>$mongotime);

  $last_collection = $collection->find($collectionQuery);

  $stations=array();
  foreach ($last_collection as $obj) {
    $lat=$obj['lat']/1000000;
    $lng=$obj['lng']/1000000;
    $marker=array($lat,$lng);
    array_push($stations,json_encode($marker));
  }

  echo json_encode($stations);
?>
