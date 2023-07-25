<?php
// Incluye la clase Conexion que maneja la conexión con PDO
include_once('conexion.php');

// Función para obtener la lista de estudiantes y sus materias
function obtenerListaEstudiantes($estudiante_nombre) {
    try {
        // Crea una instancia de la clase Conexion para establecer la conexión con PDO
        $conexion = new Conexion();
        $connectionInstance = $conexion->conectar();

        // Preparar la consulta para obtener los estudiantes y sus materias según el nombre proporcionado
        $query = "SELECT e.id as estudiante_id, e.nombre as estudiante_nombre, e.edad, m.id as materia_id, m.nombre as materia_nombre 
                  FROM estudiantes e
                  LEFT JOIN materias m ON e.id = m.estudiante_id
                  WHERE e.nombre LIKE :estudiante_nombre";

        // Preparar y ejecutar la consulta
        $stmt = $connectionInstance->prepare($query);
        $stmt->bindValue(':estudiante_nombre', "%{$estudiante_nombre}%", PDO::PARAM_STR);
        $stmt->execute();

        // Verificar si hay resultados
        if ($stmt->rowCount() > 0) {
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Listado de Estudiantes y Materias</title>
            </head>
            <body>
                <h1>Listado de Estudiantes y Materias</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID Estudiante</th>
                            <th>Nombre Estudiante</th>
                            <th>Edad</th>
                            <th>ID Materia</th>
                            <th>Nombre Materia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                            <tr>
                                <td><?php echo $fila['estudiante_id']; ?></td>
                                <td><?php echo $fila['estudiante_nombre']; ?></td>
                                <td><?php echo $fila['edad']; ?></td>
                                <td><?php echo $fila['materia_id']; ?></td>
                                <td><?php echo $fila['materia_nombre']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </body>
            </html>
            <?php
        } else {
            echo "No hay datos para mostrar para el estudiante: " . htmlspecialchars($estudiante_nombre);
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}

// Procesar el formulario de búsqueda si se ha enviado
if (isset($_GET['buscar'])) {
    $estudiante_nombre = $_GET['estudiante_nombre'];
    obtenerListaEstudiantes($estudiante_nombre);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Búsqueda de Estudiantes y Materias</title>
</head>
<body>
    <h1>Búsqueda de Estudiantes y Materias</h1>
    <form action="" method="get">
        <label for="estudiante_nombre">Nombre del Estudiante:</label>
        <input type="text" name="estudiante_nombre" id="estudiante_nombre" required>
        <input type="submit" name="buscar" value="Buscar">
    </form>
</body>
</html>
