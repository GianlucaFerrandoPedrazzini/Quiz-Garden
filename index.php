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
        <label>¡Ingresá tu nombre!<br>
        <input type="text" name="nombre" required><br>
        <input type="submit" value="Enviar"><br><br>
    </form>

    <div class="d-flex flex-column flex-md-row justify-content-center gap-1">
    <a href="quiz.php" class="center sombra1 btn btn-light btn-inicio">Start</a>
    <br>
    <a href="scores.php" class="center sombra1 btn btn-light btn-inicio">All Scores</a>
    <br>
    </div>

    <table class="table">
    <br>
    <div class="tabla">
    <thead>
    <tr>
        <th scope="col" class="center">Nroº</th>
        <th scope="col">Alias</th>
        <th scope="col">Score</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row" class="center">1</th>
        <td>José</td> <!--Alias-->
        <td>9023</td> <!--Score-->
    </tr>
    <tr>
        <th scope="row" class="center">2</th>
        <td>Lemodesert</td> <!--Alias-->
        <td>8753</td> <!--Score-->
    </tr>
    <tr>
        <th scope="row" class="center">3</th>
        <td>Santipejo2</td> <!--Alias-->
        <td>8586</td> <!--Score-->
    </tr>
    <tr>
        <th scope="row" class="center">4</th>
        <td>Mónaca L.K.</td> <!--Alias-->
        <td>7854</td> <!--Score-->
    </tr>
    <tr>
        <th scope="row" class="center">5</th>
        <td>La rana rené</td> <!--Alias-->
        <td>7423</td> <!--Score-->
    </tr>
    </tbody>
    </table>
    </div>
    </body>
    <?php
        //Ejecuto toda esta sección, que es como un "setup" para el resto del juego, solo cuando se
        //envía el nombre del jugador (actualmente no es obligatorio ni tiene límite. Corregir)
        if (isset($_POST["nombre"]) && $_POST["nombre"]){
            //Inicio la sesión. Todas las variables de la sesión pueden usarse en los otros archivos
            //en los que también se inicie la sesión
            session_start(); 
            
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
            //Guardo las preguntas y su respuesta correcta en el orden en que están planteados
            //originalmente dentro de la variable "orden_og" de la sesión ("og" significa "original")
            $_SESSION["orden_og"] = [
                ["A potato is...", "A tubercle"],
                ["An eggplant is...", "A fruit"],
                ["Why do people use a greenhouse?", "To grow plants all year round"],
                ["Which one is part of a flower?", "Petal"],
                ["What part of the plant is under the soil?", "Root"]
            ];
            //Guardo los datos de la conexión a la base de datos en la variable "db" de la sesión
            $_SESSION["bd"] = $conexion;
            //Guardo el valor 1 en la variable "ronda" de la sesión. Esta variable va a servir para saber
            //cuántas veces se respondieron preguntas (es como un while con variable incremental de
            //condición de salida solo que ente archivos)
            $_SESSION["ronda"] = 0;
            //Creo un array que voy guardando en la variable "jugador" de la sesión, el cual contiene
            //el nombre del jugador y sus puntajes que se guardan en el orden original de las preguntas
            $_SESSION["jugador"] = [$_POST["nombre"], "", "", "", "", "", ""];
        }
    ?>
</html>