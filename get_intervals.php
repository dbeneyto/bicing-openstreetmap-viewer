<?php

  // open connection to MongoDB server
  $conn = new Mongo('localhost');

  // access database
  $db = $conn->bicing;

  // access collection
  $collection = $db->data;

//header("Content-type: text/json");

  $element = $collection->distinct('timestamp');
//  var_dump($element);

  $timestamp_list = array();
  foreach ($element as $obj) {
     $mongotime = New Mongodate($obj->sec);
     array_push($timestamp_list,date('Y-m-d H:i:s',$obj->sec));
  }
//var_dump($timestamp_list);

/*
  $mongotime = New Mongodate($last_timestamp);
  $collectionQuery=array('timestamp'=>$mongotime);

  $last_collection = $collection->find($collectionQuery);

  $stations=array();
  foreach ($last_collection as $obj) {
    $lat=$obj['lat']/1000000;
    $lng=$obj['lng']/1000000;
    $ocupation=$obj['free']*100/($obj['bikes']+$obj['free']);
    $marker=array($lat,$lng,$ocupation);
    array_push($stations,json_encode($marker));
  }
*/
  echo json_encode($timestamp_list);
?>
