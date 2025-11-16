<?php session_start(); //Inicio la sesión
    
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "quiz_garden";

    $conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

    //Extraigo los datos de las variables "orden" y "ronda" para usarlos en este archivo
    //sin tener que citar a la sesión a cada rato
    $preguntas = $_SESSION["orden"];
    $ronda = $_SESSION["ronda"];

    //Declaro una variable que sirve para saber cuando cambiar de archivo
    $terminar = 0;

    //En base a la ronda en la que se encuentra, cambio los textos de la pregunta
    //y los botones por los ordenados aleatoriamente
    //pongo a la variable con el texto de la pregunta como la pregunta del primer array mezclado
    $quiz = $preguntas[$ronda][0]; 

    //pongo a las variables con el texto de los botones como las posibles respuestas del primer
    //array mezclado
    $respuesta1 = $preguntas[$ronda][1];
    $respuesta2 = $preguntas[$ronda][2];
    $respuesta3 = $preguntas[$ronda][3];
    $respuesta4 = $preguntas[$ronda][4];

    //Reviso a qué pregunta del orden original corresponde la que se está mostrando actualmente y en base
    //a eso me fijo si la respuesta que elije es correcta o incorrecta.
    //En cualquiera de los 2 casos cambio el valor de la variable "fin" para que indique que
    //se terminó de responder
    if ($quiz == "A potato is..."){ //Comparo la pregunta que se muestra con una de las posibles preguntas
        //si es esa la pregunta y el jugador ya respondió (que se chequea con el "isset") y la respuesta
        //es la correcta:
        if (isset($_POST["accion"]) && $_POST["accion"] == "A tubercle"){
            //Guardo en el lugar correspondiente a esta pregunta en la base de datos el puntaje
            //correspondiente al tiempo transcurrido obtenido del POST con el cual interactúo desde
            //JavaScript
            $registrar = "INSERT INTO jugadores (pregunta1) values ('$_POST[puntaje]')";
            mysqli_query($conexion, $registrar);
            
            $terminar = 1;
        }
        //si ya respondío pero la respuesta no es la correcta:
        //(por cierto repito la estructura porque tengo que comprobar que se haya respondido)
        elseif (isset($_POST["accion"]) && $_POST["accion"] != "A tubercle"){
            //Le doy 0 puntos y lo guardo en la base de datos en 
            $registrar = "INSERT INTO jugadores (pregunta1) values (0)";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
    }

    //La misma idea se repite en los siguientes casos

    elseif ($quiz == "An eggplant is..."){
        if (isset($_POST["accion"]) && $_POST["accion"] == "A fruit"){
            $registrar = "INSERT INTO jugadores (pregunta2) values ('$_POST[puntaje]')";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != "A fruit"){
            $registrar = "INSERT INTO jugadores (pregunta2) values (0)";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
    }
    elseif ($quiz == "Why do people use a greenhouse?"){
        if (isset($_POST["accion"]) && $_POST["accion"] == "To grow plants all year round"){
            $registrar = "INSERT INTO jugadores (pregunta3) values ('$_POST[puntaje]')";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != "To grow plants all year round"){
            $registrar = "INSERT INTO jugadores (pregunta3) values (0)";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
    }
    elseif ($quiz == "Which one is part of a flower?"){
        if (isset($_POST["accion"]) && $_POST["accion"] == "Petal"){
            $registrar = "INSERT INTO jugadores (pregunta4) values ('$_POST[puntaje]')";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != "Petal"){
            $registrar = "INSERT INTO jugadores (pregunta4) values (0)";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
    }
    else{
        if (isset($_POST["accion"]) && $_POST["accion"] == "Root"){
            $registrar = "INSERT INTO jugadores (pregunta5) values ('$_POST[puntaje]')";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != "Root"){
            $registrar = "INSERT INTO jugadores (pregunta5) values (0)";
            mysqli_query($conexion, $registrar);
            $terminar = 1;
        }
    }
    if ($terminar == 1){ //Si se define que se terminó de responder:
        header("Location: informacion.php"); 
        exit();
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Garden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <div id="p"></div>
    <div class="div">
        <div class="barra-tiempo">
            <div class="icono-reloj">
                <div class="reloj-agujas"></div>
            </div>
            <div class="barra-exterior">
                <div class="barra-interior" id="barraProgreso"></div>
            </div>
        </div>

        <div id="temporizador" class="temporizador">60</div>
        <div class="div-quiz">
            <div class="center pregunta">
                <!--Pongo la pregunta del quiz como el valor de la variable que contiene a la pregunta
                correspondiente a esta ronda-->
                <p><?php echo $quiz ?></p>
            </div>
            <p></p>
            <!--En lugar de darles "values" definidos a los botones y un texto en específico le asigno
            los valores de las variables de las posibles respuestas-->
            <form method="POST">
                <!-- Input oculto para pasar el puntaje de JavaScript a PHP -->
                <input type="hidden" name="puntaje" id="puntajeID">
                <!-- Contenedor con los primeros 2 botones -->
                <div class="contenedor">
                    <!-- Botón 1 -->
                    <div class="azul center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?php $respuesta1 ?>"><?php echo $respuesta1 ?></button>
                    </div>
                    <!-- Botón 2 -->
                    <div class="naranja center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?php $respuesta2 ?>"><?php echo $respuesta2 ?></button>
                    </div>
                </div>
                <!-- División entre contenedores -->
                <p></p> 
                <!-- Contenedor con los últimos 2 botones -->
                <div class="contenedor">
                    <!-- Botón 3 -->
                    <div class="morado center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?php $respuesta3 ?>"><?php echo $respuesta3 ?></button>
                    </div>
                    <!-- Botón 4 -->
                    <div class="rojo center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?php $respuesta4 ?>"><?php echo $respuesta4 ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variables de puntaje y tiempo de juego
        let contador = 60;
        let puntaje = 1000;
        function cronometro(){
            contador--; //Decrecimiento del valor del contador
            //Muestra del valor del contador
            document.getElementById("temporizador").textContent=contador;
            //Si el contador llega a 0 el puntaje es 0 y se avisa que se quedó sin tiempo pero puede
            //seguir jugando
            if (contador <= 0) {
                document.getElementById("temporizador").textContent="Te quedaste sin tiempo";
                puntaje = 0;
            }
            //Si el contador baja de 57 y pero no es menor ni igual a 0 se comienza a descontar 17.55 del
            //puntaje
            if (contador < 57 && contador > 0){
                puntaje = puntaje - 17.55;
            }
            //Pongo el valor del puntaje en el POST para pasarlo a PHP
            document.getElementById("puntajeID").value = Math.round(puntaje);
            //Imprimo el valor del puntaje para que yo lo pueda ver
            document.getElementById("p").innerHTML=Math.round(puntaje);
        }
        //La función cronometro que es la que hace funcionar todo el JavaScript se ejecuta cada 1000 
        //milisegundos (1 segundo)
        setInterval(cronometro, 1000);
    </script>
</body>

</html>
