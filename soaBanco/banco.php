<?php
// Incluye la clase Conexion que maneja la conexión con PDO
include_once('conexion.php');

// Función para procesar el depósito
function procesarDeposito() {
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
}

// Muestra el formulario y los resultados
try {
    procesarDeposito();

    // Realiza la consulta para obtener las transacciones actualizadas
    $query = "SELECT t.id, c1.numero_cuenta as cuenta_origen, c2.numero_cuenta as cuenta_destino, t.monto, t.fecha_hora 
              FROM transacciones t
              INNER JOIN cuentas c1 ON t.cuenta_origen = c1.id
              INNER JOIN cuentas c2 ON t.cuenta_destino = c2.id";

    // Ejecutar la consulta y obtener el resultado
    $conexion = new Conexion();
    $connectionInstance = $conexion->conectar();
    $resultado = $connectionInstance->query($query);

    // Verificar si hay resultados
    if ($resultado->rowCount() > 0) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Depósito Bancario</title>
        </head>
        <body>
            <h1>Depósito Bancario</h1>
            <form name="deposito_form" method="post">
                <label for="cuenta">Número de Cuenta:</label>
                <input type="text" id="cuenta" name="cuenta" required>
                <br>
                <label for="monto">Monto a Depositar:</label>
                <input type="number" id="monto" name="monto" step="0.01" required>
                <br>
                <input type="submit" value="Realizar Depósito">
            </form>

            <!-- Mostrar los resultados en una tabla HTML -->
            <table>
                <thead>
                    <tr>
                        <th>ID Transacción</th>
                        <th>Cuenta Origen</th>
                        <th>Cuenta Destino</th>
                        <th>Monto Transferido</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo $fila['cuenta_origen']; ?></td>
                            <td><?php echo $fila['cuenta_destino']; ?></td>
                            <td><?php echo $fila['monto']; ?></td>
                            <td><?php echo $fila['fecha_hora']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </body>
        </html>
        <?php
    } else {
        echo "No hay datos para mostrar.";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>
