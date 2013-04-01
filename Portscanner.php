<?php

/*
  Copyright 2012
  Deveoper @c1ck0
*/

set_time_limit(0);
error_reporting(0);

if($argc == 3) {
  if(strpos($argv[2], "-")) {
    $ports = explode("-", $argv[2]);
  } else {
    $port = $argv[2];
  } 

  $host = $argv[1];
} else {
  echo "Syntax : php $argv[0] [host] start-end\n";
  exit;
}

while(true) {
  if(isset($ports)) {
    if($ports[0] < 1) {
      $start = 1;
    } else {
      $start = $ports[0];
    } if($ports[1] > 65535) {
      $end = 65535;
    } else {
      $end = $ports[1];
    }

    for($start; $start <= $end; $start++) {
      $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
      if(socket_connect($sock, $host, $start)) {
        echo "port $start is open.\n";
        socket_close($sock);
      } else {
        echo "port $start is closed.\n";
        socket_close($sock);
      }
    } 

    break;
  } else {
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if(socket_connect($sock, $host, $port)) {
      echo "port $port is open.\n";
      socket_close($sock);
    } else {
      echo "port $port is closed.\n";
      socket_close($sock);
    }
    break;
  }
}

?>
