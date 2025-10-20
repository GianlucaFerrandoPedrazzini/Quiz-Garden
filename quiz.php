<?php
    session_start(); //Inicio la sesión
    //Extraigo los datos de las variables "orden", "ronda" y "orden_og" para usarlos en este archivo
    //sin tener que citar a la sesión a cada rato
    $preguntas = $_SESSION["orden"];
    $ronda = $_SESSION["ronda"];
    $orden_og = $_SESSION["orden_og"];
    //Declaro una variable que sirve para saber cuando cambiar de archivo
    $fin = 0;

    //Analizo en qué número de ronda está el jugador y en base a eso cambio los textos de la pregunta
    //y los botones por los ordenados aleatoriamente
    if($ronda == 1){ //Si es la ronda 1
        //pongo a la variable con el texto de la pregunta como la pregunta del primer array mezclado
        $quiz = $preguntas[0][0]; 
        //pongo a las variables con el texto de los botones como las posibles respuestas del primer
        //array mezclado
        $respuesta1 = $preguntas[0][1];
        $respuesta2 = $preguntas[0][2];
        $respuesta3 = $preguntas[0][3];
        $respuesta4 = $preguntas[0][4];
    }

    //Así funciona sucesivamente con el resto de rondas, sería como el número de ronda corresponde a
    //cúal array de la matriz se va a mostrar (solo que si es la ronda 1 sería el array 0, ronda 2
    //array 1 y así)

    elseif($ronda == 2){
        $quiz = $preguntas[1][0];
        $respuesta1 = $preguntas[1][1];
        $respuesta2 = $preguntas[1][2];
        $respuesta3 = $preguntas[1][3];
        $respuesta4 = $preguntas[1][4];
    }
    elseif($ronda == 3){
        $quiz = $preguntas[2][0];
        $respuesta1 = $preguntas[2][1];
        $respuesta2 = $preguntas[2][2];
        $respuesta3 = $preguntas[2][3];
        $respuesta4 = $preguntas[2][4];
    }
    elseif($ronda == 4){
        $quiz = $preguntas[3][0];
        $respuesta1 = $preguntas[3][1];
        $respuesta2 = $preguntas[3][2];
        $respuesta3 = $preguntas[3][3];
        $respuesta4 = $preguntas[3][4];
    }
    else{
        $quiz = $preguntas[4][0];
        $respuesta1 = $preguntas[4][1];
        $respuesta2 = $preguntas[4][2];
        $respuesta3 = $preguntas[4][3];
        $respuesta4 = $preguntas[4][4];
    }

    //Reviso a qué pregunta del orden original corresponde la que se está mostrando actualmente y en base
    //a eso me fijo si la respuesta que elije es correcta (y le doy 1000 puntos) o incorrecta (y le doy 0
    //puntos). En cualquiera de los 2 casos cambio el valor de la variable "fin" para que indique que
    //se terminó de responder
    if ($quiz == $orden_og[0][0]){ //Comparo la pregunta que se muestra con la primera del orden original
        //si es esa la pregunta y el jugador ya respondío (que se chequea con el "isset") y la respuesta
        //es la correcta guardada en el array del orden original:
        if (isset($_POST["accion"]) && $_POST["accion"] == $orden_og[0][1]){
            //Le doy 1000 puntos que los guardo en el índice correspondiente a la primera pregunta en el
            //array de los datos del jugador guardada en la variable "jugador" de la sesiónv
            $_SESSION["jugador"][1] = 1000; 
            $fin = 1; //pongo en alto la variable bandera que indica que se respondió
        }
        //si ya respondío pero la respuesta no es la correcta:
        //(por cierto repito la estructura porque tengo que comprobar que se alla respondido)
        elseif (isset($_POST["accion"]) && $_POST["accion"] != $orden_og[0][1]){
            //Le doy 0 puntos que los guardo en el índice correspondiente a la primera pregunta en el
            //array de los datos del jugador guardada en la variable "jugador" de la sesiónv
            $_SESSION["jugador"][1] = 0; 
            $fin = 1; //pongo en alto la variable bandera que indica que se respondió
        }
    }

    //La misma idea se repite en los siguientes casos

    elseif ($quiz == $orden_og[1][0]){
        if (isset($_POST["accion"]) && $_POST["accion"] == $orden_og[1][1]){
            $_SESSION["jugador"][2] = 1000;
            $fin = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != $orden_og[1][1]){
            $_SESSION["jugador"][2] = 0;
            $fin = 1;
        }
    }
    elseif ($quiz == $orden_og[2][0]){
        if (isset($_POST["accion"]) && $_POST["accion"] == $orden_og[2][1]){
            $_SESSION["jugador"][3] = 1000;
            $fin = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != $orden_og[2][1]){
            $_SESSION["jugador"][3] = 0;
            $fin = 1;
    }
    }
    elseif ($quiz == $orden_og[3][0]){
        if (isset($_POST["accion"]) && $_POST["accion"] == $orden_og[3][1]){
            $_SESSION["jugador"][4] = 1000;
            $fin = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != $orden_og[3][1]){
            $_SESSION["jugador"][4] = 0;
            $fin = 1;
        }
    }
    else{
        if (isset($_POST["accion"]) && $_POST["accion"] == $orden_og[4][1]){
            $_SESSION["jugador"][5] = 1000;
            $fin = 1;
        }
        elseif (isset($_POST["accion"]) && $_POST["accion"] != $orden_og[4][1]){
            $_SESSION["jugador"][5] = 0;
            $fin = 1;
        }
    }
    if ($fin == 1){ //Si se define que se terminó de responder 
        $_SESSION["ronda"] = $ronda + 1; //sumo 1 al número de rondas recorridas
        header("Location: informacion.php"); //envío al jugador al archivo con la data de la respuesta
        exit();//hago que se deje de ejecutar este código (es necesario cuando se usa "header()")
    }
    ?>

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
                <p><?= $quiz ?></p>
            </div>
            <p></p>
            <!--En lugar de darles "values" definidos a los botones y un texto en específico le asigno
            los valores de las variables de las posibles respuestas-->
            <form method="POST">
                <div class="contenedor">
                    <div class="azul center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?= $respuesta1 ?>"><?= $respuesta1 ?></button>
                    </div>
                    <div class="naranja center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?= $respuesta2 ?>"><?= $respuesta2 ?></button>
                    </div>
                </div>
                <p></p>
                <div class="contenedor">
                    <div class="morado center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?= $respuesta3 ?>"><?= $respuesta3 ?></button>
                    </div>
                    <div class="rojo center">
                        <button type="submit" class="btn btn-secondary" name="accion" value="<?= $respuesta4 ?>"><?= $respuesta4 ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        let contador = 60;
        let puntaje = 1000;
        function cronometro(){
            contador--;
            document.getElementById("temporizador").textContent=contador;
            if (contador <= 0) {
            document.getElementById("temporizador").textContent="Te quedaste sin tiempo";
            }
            if (contador < 58){
                puntaje = puntaje - 16.6
            }
        }
        setInterval(cronometro, 1000);
    </script>
</body>
</html>