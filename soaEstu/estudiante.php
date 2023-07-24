<?php
// Incluye la clase Conexion que maneja la conexión con PDO
include_once('conexion.php');

// Función para obtener la lista de estudiantes y sus materias
function obtenerListaEstudiantes() {
    try {
        // Crea una instancia de la clase Conexion para establecer la conexión con PDO
        $conexion = new Conexion();
        $connectionInstance = $conexion->conectar();

        // Realiza la consulta para obtener los estudiantes y sus materias
        $query = "SELECT e.id as estudiante_id, e.nombre as estudiante_nombre, e.edad, m.id as materia_id, m.nombre as materia_nombre 
                  FROM estudiantes e
                  LEFT JOIN materias m ON e.id = m.estudiante_id";

        // Ejecutar la consulta y obtener el resultado
        $resultado = $connectionInstance->query($query);

        // Verificar si hay resultados
        if ($resultado->rowCount() > 0) {
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
                        <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) : ?>
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
            echo "No hay datos para mostrar.";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}

// Llama a la función para obtener la lista de estudiantes y materias
obtenerListaEstudiantes();
?>
