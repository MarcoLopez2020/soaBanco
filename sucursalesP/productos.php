<?php
// Función para listar los productos en las sucursales
function listarProducto($producto) {
    // Incluir la conexión con la base de datos
    include_once("conexion.php");

    // Obtener la instancia de la conexión
    $conexion = new Conexion();
    $connectionInstance = $conexion->Conectar();

    try {
        // Realiza la consulta para obtener los productos en las sucursales
        $query = "SELECT p.nombre AS producto, s.nombre AS sucursal, ps.cantidad 
                  FROM productos_sucursales ps
                  INNER JOIN productos p ON ps.producto_id = p.id
                  INNER JOIN sucursales s ON ps.sucursal_id = s.id
                  WHERE p.nombre = ?";

        $stmt = $connectionInstance->prepare($query);
        $stmt->execute([$producto]);

        // Verificar si hay resultados
        if ($stmt->rowCount() > 0) {
            ?>
            <!-- Mostrar los resultados en una tabla HTML -->
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Sucursal</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalCantidad = 0; // Variable para almacenar el total de la cantidad

                    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) : 
                        $totalCantidad += $fila['cantidad']; // Sumar la cantidad a totalCantidad
                    ?>
                        <tr>
                            <td><?php echo $fila['producto']; ?></td>
                            <td><?php echo $fila['sucursal']; ?></td>
                            <td><?php echo $fila['cantidad']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <!-- Mostrar el total de la cantidad al final de la tabla -->
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Total:</strong></td>
                        <td><?php echo $totalCantidad; ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php
        } else {
            echo "No se encontraron resultados para el producto '$producto'.";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta Productos en Sucursales</title>
</head>
<body>
    <h1>Consulta Productos en Sucursales</h1>

    <!-- Formulario para buscar un producto -->
    <form action="productos.php" method="get">
        <label for="producto">Nombre del Producto:</label>
        <input type="text" id="producto" name="producto" required>
        <br>
        <input type="submit" value="Buscar Producto">
    </form>

    <?php
    if (isset($_GET['producto'])) {
        $producto = $_GET['producto'];
        listarProducto($producto);
    }
    ?>
</body>
</html>
