<?php
$config = file_get_contents('conf.ini');
$res = parse_ini_string($config, false);
foreach ($res as $key => $value) {
    $ini = ini_set($key, "On");
}
header('location: ../index.php');