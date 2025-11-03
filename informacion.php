<?php
    session_start();
    
    //Defino los datos de la base de datos (en este caso es una local. Cambiar por la de
    //infinityfree)
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "quiz_garden";
    //Guardo los datos de la base en una variable que sirve para establecer la conexión
    $conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

    if (!isset($_SESSION["orden"]) || !isset($_SESSION["ronda"])) {
        header("Location: index.php");
        exit();
    }

    $next = "quiz.php";

    $preguntas = $_SESSION["orden"];
    $ronda = $_SESSION["ronda"];
    
    $informacion = $preguntas[$ronda][5];
    $imagen = $preguntas[$ronda][6];

    if ($ronda == 4){
        $next = "index.php";

        $datos = $_SESSION['jugador'];

        $total = $datos[1] + $datos[2] + $datos[3] + $datos[4] + $datos[5];

        $enviar = "INSERT INTO jugadores (nombre, pregunta1, pregunta2, pregunta3, pregunta4, pregunta5, total_puntos) VALUES ('$datos[0]', '$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$datos[5]', '$total')";

        mysqli_query($conexion, $enviar);
    }
    $_SESSION["ronda"] = $ronda + 1; //sumo 1 al número de rondas recorridas
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
    <div class="div_info">
        <div class="center pregunta sombra_info">
            <img height="30%" width="30%" src="img/<?php echo $imagen; ?>" alt="Imagen" class="img">
        </div>
        <br>
        <div class="center pregunta">
            <p><?= $informacion ?></p>
        </div>
    </div>
    <p></p>
    <div class="next_div">
        <div class="next center">
            <a href="<?php echo $next ?>" type="button" class="btn next_button">Next</a>
        </div>    
    </div>
</body>
</html>