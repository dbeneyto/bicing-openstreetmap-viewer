<!DOCTYPE HTML>
<html>
<head>
<title>MongoDB range search</title>
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

  $last_element = $collection->find()->sort(array('_id' => -1))->limit(1);
  $first_element = $collection->find()->sort(array('_id' => 1))->limit(1);

  echo "Data captured from: ";

  foreach ($first_element as $obj) {
     echo date('Y-m-d H:i:s',$obj['timestamp']->sec);
  }

  echo " to: ";

  foreach ($last_element as $obj) {
     echo date('Y-m-d H:i:s',$obj['timestamp']->sec);
  }

  // disconnect from server
  $conn->close();
} catch (MongoConnectionException $e) {
  die('Error connecting to MongoDB server');
} catch (MongoException $e) {
  die('Error: ' . $e->getMessage());
}
?>
</body>
</html>
