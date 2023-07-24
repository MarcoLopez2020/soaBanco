<?php
// Incluye la clase Conexion que maneja la conexión con PDO
include_once('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuenta = $_POST['cuenta'];
    $monto = $_POST['monto'];

    try {
        // Crea una instancia de la clase Conexion para establecer la conexión con PDO
        $conexion = new Conexion();
        $connectionInstance = $conexion->conectar();

        // Realizar la inserción en la tabla "transacciones"
        $query = "INSERT INTO transacciones (cuenta_origen, cuenta_destino, monto) VALUES (?, ?, ?)";
        $stmt = $connectionInstance->prepare($query);
        $stmt->execute([$cuenta, $cuenta, $monto]);

        echo "Depósito realizado con éxito.";
    } catch (PDOException $e) {
        echo "Error al realizar el depósito: " . $e->getMessage();
    }
}
?>
