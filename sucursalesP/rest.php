<?php
$op=$_SERVER['REQUEST_METHOD'];
include_once('select.php');
switch ($op) {
    case 'GET':
        $nombre=$_GET['nombre'];
        CrudS::listar($nombre);
        break;
    
    default:
        # code...
        break;
}
?>