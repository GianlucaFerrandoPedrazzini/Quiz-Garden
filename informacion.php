<?php session_start();

    $ronda = $_SESSION["ronda"];

    //Por default el texto del botón para pasar a la siguiente pregunta es "Next"
    $next_button = "Next";
    
    //Si la ronda fue la última cambio el texto del botón por "End"
    if ($ronda == 4){
        $next_button = "End";
    }

    //Traigo todos los datos necesarios para mostrar la información de la respuesta correcta
    $preguntas = $_SESSION["orden"];
    $ronda = $_SESSION["ronda"];
    $informacion = $preguntas[$ronda][5];
    $imagen = $preguntas[$ronda][6];

    //Si se presiona el botón para pasar a la siguiente pregunta:
    if (isset($_POST["pasar"])){
        if ($ronda < 4){ //Si la ronda no fue la última:
            $_SESSION["ronda"] = $ronda + 1; //sumo 1 al número de rondas recorridas
            header("Location: quiz.php"); //Redirijo al jugador al archivo del quiz
            exit();
        }
        else{ //Si la ronda fue la última
            header("Location: final.php"); //Redirijo al jugador al archivo final.php
            exit();
        }
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
    <!-- Div para toda la información -->
    <div class="div_info">
        <!-- Div con la imagen ilustrativa -->
        <div class="center pregunta sombra_info">
            <img height="30%" width="30%" src="img/<?php echo $imagen; ?>" alt="Imagen" class="img">
        </div>
        <br>
        <!-- Div con la información textual que da contexto a la respuesta -->
        <div class="center pregunta">
            <p><?php echo $informacion ?></p>
        </div>
    </div>
    <p></p>
    <div class="next_div">
        <!-- Div para dejar bonito el botón -->
        <div class="next center">
            <!-- Post con el botón para pasar a la siguiente pregunta -->
            <form method="post">
                <button type="submit" name="pasar" class="btn next_button"><?php echo $next_button?></button>
            </form>
        </div>    
    </div>
</body>
</html>