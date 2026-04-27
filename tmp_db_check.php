<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
$m = new mysqli('127.0.0.1','brilliant','99TF6S6QynGrU2GEy0iV','laravelapp',3306);
if ($m->connect_error) { echo 'ERR:'.$m->connect_error; exit(1); }
$q = "SELECT COUNT(*) AS total, COUNT(CASE WHEN slug IS NOT NULL AND slug<>'' THEN 1 END) AS has_slug, COUNT(CASE WHEN is_active=1 THEN 1 END) AS active, COUNT(CASE WHEN is_active=0 THEN 1 END) AS inactive, COUNT(CASE WHEN is_active IS NULL THEN 1 END) AS null_active FROM products";
$res = $m->query($q);
if (!$res) { echo 'ERRQ:'.$m->error; exit(1); }
$row = $res->fetch_assoc();
echo json_encode($row);
