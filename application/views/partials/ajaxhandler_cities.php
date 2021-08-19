<?php
    $cities = get_india_cities();
    // var_dump($cities);exit;
  $data=array();
  foreach($cities as $city){
      $sk=array("id"=>strval($city->id),"key"=>$city->name,"suggestion"=>$city->name,"suggestable"=>"true");
      $data[strval($city->id)] = $sk;
      
  }
  // var_dump($data);
  // exit;

  function namefilter($var) {
    return (stripos($var['suggestion'], $_GET['search']) !== false);
  }

  $aResult = array();
  if ($_GET['elementId'] == 'ajax_cities' ||$_GET['elementId'] == 'ajax_cities1' ) {
    $aResult = array_filter($data, 'namefilter');
  }

  if (count($aResult) == 0) {
    echo "{}";
  }
  else {
    echo json_encode($aResult);
  }
?>