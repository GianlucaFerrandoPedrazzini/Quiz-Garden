<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <title>Scores</title>
</head>
<body>
    <!-- Botón para volver al inicio -->
    <div>
        <a href="index.php" type="button" class="sombra1 btn btn-light btn-volver">Return to menu</a>
    </div>
    <br>
    <!-- Tabla para mostrar a todos los jugadores con sus puntajes totales -->
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th class="center">Player</th>
                <th class="center">Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
                //Defino los datos de la base de datos (en este caso es una local. Cambiar por la de
                //infinityfree)
                $servidor = "localhost";
                $usuario = "root";
                $clave = "";
                $bd = "quiz_garden";
                //Guardo los datos de la base en una variable que sirve para establecer la conexión
                $conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

                //Traigo a todos los jugadores de la tabla de jugadores junto con sus puntajes totales
                //de mayor a menor
                $sql = "SELECT nombre, total_puntos FROM jugadores ORDER BY total_puntos DESC";
                $resultado = mysqli_query($conexion, $sql);

                //Creo más filas de la tabla según jugadores traidos
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["total_puntos"]) . "</td>";
                        echo "</tr>";
                    }
                //Si no hay jugadores en la tabla se avisa
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No hay jugadores registrados</td></tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>