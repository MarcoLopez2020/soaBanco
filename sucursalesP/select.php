<?php
class CrudS{
    public static function listar($nombre){
        include_once('conexion.php');
        $objeto=new Conexion();
        $conexion=$objeto->conectar();
        $consulta="SELECT SUM(CANTIDAD) from sucursal where producto=(SELECT id_pro from producto where nom_pro='$nombre')";
        $resultado=$conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }
}
?>