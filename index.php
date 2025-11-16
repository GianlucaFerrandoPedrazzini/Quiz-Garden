<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Garden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <div class="cartel">
        <h1 class="titulo-menu">Welcome to Quiz Garden!</h1>
    </div>

    <br>

    <!--Este es el form que uso para llevar a cabo el "setup" en php y para saber el nombre del jugador-->
    <form method="POST" class="center">
        <label>Enter your name!<br>
        <input type="text" name="nombre" required><br><br>
        <button type="submit" value="Enviar" class="center sombra1 btn btn-light btn-inicio">Start</button>
        <br>
    </form>

    <!--Botón que me lleva a scores.php-->
    <a href="scores.php" class="center sombra1 btn btn-light btn-inicio">All scores</a>

    <!-- Tabla con el top 5 de mejores jugadores -->
    <table class="table">
        <br>
        <div class="tabla">
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

                // Traigo de la base de datos los nombre de los 5 jugadores con más puntos y sus puntajes
                $sql = "SELECT nombre, total_puntos FROM jugadores ORDER BY total_puntos DESC LIMIT 5";
                $resultado = mysqli_query($conexion, $sql);

                // Creo una nueva fila de la tabla de acuerdo a la cantidad de jugadores que se trae
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["total_puntos"]) . "</td>";
                        echo "</tr>";
                    }
                // Si no hay jugadores en la base de datos lo menciona
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No hay jugadores registrados</td></tr>";
                }
            ?>
        </tbody>
    </table>
    </div>
    </body>
    <?php
        //Defino los datos de la base de datos (en este caso es una local. Cambiar por la de
        //infinityfree)
        $servidor = "localhost";
        $usuario = "root";
        $clave = "";
        $bd = "quiz_garden";
        //Guardo los datos de la base en una variable que sirve para establecer la conexión
        $conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

        //Ejecuto toda esta sección, que es como un "setup" para el resto del juego, solo cuando se
        //envía el nombre del jugador (actualmente no es obligatorio ni tiene límite. Corregir)
        if (isset($_POST["nombre"])){
            //Inicio la sesión. Todas las variables de la sesión pueden usarse en los otros archivos
            //en los que también se inicie la sesión

            $revisar = "SELECT * FROM jugadores WHERE nombre = '$_POST[nombre]'";
            $sql = mysqli_query($conexion, $revisar);

            if (mysqli_num_rows($sql) == 1){
                echo("<script>alert('That username is already used. Please select another');</script>");
            }
            else{
                $registrar = "INSERT INTO jugadores (nombre) values ('$_POST[nombre]')";

                //Defino variables con arrays cuyo contenido son las preguntas de los quizes en el índice 0 y
                //las posibles respuestas en los siguientes. En este caso las preguntas están dispuestas en
                //orden en el que están en el documento del videojuego pero las respuestas están mezcladas
                $pregunta1 = ["A potato is...", "A tubercle", "A vegetable", "A fruit", "A good defense for zombies", "The potato is a tubercle commonly used for making potato chips", "papa.jpg"];
                $pregunta2 = ["An eggplant is...", "A tubercle", "A vegetable", "A fruit", "A good defense for zombies", "An eggplant is a fruit because it has seeds on its inside", "berenjena.png"];
                $pregunta3 = ["Why do people use a greenhouse?", "To play videogames", "To grow plants all year round", "To study", "To cook", "Greenhouses are used for growing plants all year round because they maintain a regular environmental condition and protect them from plagues and others natural dangers", "invernadero.jpeg"];
                $pregunta4 = ["Which one is part of a flower?", "Metal", "Leaf", "Root", "Petal", "The petal is part of the flower and is commonly recognized for its vivid colors and different shapes and sizes", "flor.jpeg"];
                $pregunta5 = ["What part of the plant is under the soil?", "Stem", "Fruit", "Root", "Flower", "The only part of the plant that is under the soil is the root. It helps them nourish themselves and keep attached to the floor", "root.png"];
                
                //Meto todos los arrays de las preguntas en otro array creando una matriz y las mezclo
                $preguntas = [$pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5];
                shuffle($preguntas);

                //Guardo este orden aleatorio en la variable "orden" de la sesión
                $_SESSION["orden"] = $preguntas;
                
                //Guardo el valor 0 en la variable "ronda" de la sesión. Esta variable va a servir para saber
                //cuántas veces se respondieron preguntas (es como un while con variable incremental de
                //condición de salida solo que entre archivos)
                $_SESSION["ronda"] = 0;

                //Creo la variable "jugador" de la sesión en la que guardo el nombre del jugador
                $_SESSION["jugador"] = $_POST['nombre'];

                //Redirijo al jugador al quiz
                header("Location: quiz.php");
                exit();
            }
        }
    ?>
</html>