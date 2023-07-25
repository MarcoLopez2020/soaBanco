<?php
class Conexion
{
    public function Conectar()
    {
        define("servidor", "localhost");
        define("nombre", "pruebaF");
        define("usuario", "root");
        define("password", "");
        $opciones=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');
        try {
            $conexion= new PDO("mysql:host=".servidor.";dbname=".nombre,usuario,password,$opciones);
            return $conexion;
        } catch (Exception $e) {
            die("Error".$e->getMessage());
        }
    }
}
?>