<?php session_start();

    //Defino los datos de la base de datos (en este caso es una local. Cambiar por la de
    //infinityfree)
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "quiz_garden";
    //Guardo los datos de la base en una variable que sirve para establecer la conexión
    $conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

    //Testeo para ver si anda la sesión (andaba todo menos los puntajes 😭)
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    // Traigo los puntajes individuales del jugador de la base de datos donde el dato de la columna 
    //"nombre" es igual al del jugador
    $traer = "SELECT pregunta1, pregunta2, pregunta3, pregunta4, pregunta5 FROM jugadores WHERE nombre = '$_SESSION[jugador]'";

    $sql = mysqli_query($conexion, $traer);
    $resultado = $sql->fetch_assoc();

    //Defino variables para saber cuantas respuestas respondió bien o mal el jugador
    $wrong = 0;
    $correct = 0;

    //Sumo el total de puntos del jugador
    $total = $resultado["pregunta1"] + $resultado['pregunta2'] + $resultado['pregunta3'] + $resultado['pregunta4'] + $resultado['pregunta5'];

    // Crequeo cada puntaje individual del jugador. Si es 0 sumo 1 a la variable que indica que se 
    //equivocó y no es 0 sumo 1 a la variable que indica que acertó

    if ($resultado['pregunta1'] == 0){
        $wrong += 1;
    }
    else{
        $correct += 1;
    }
    if ($resultado['pregunta2'] == 0){
        $wrong += 1;
    }
    else{
        $correct += 1;
    }
    if ($resultado['pregunta3'] == 0){
        $wrong += 1;
    }
    else{
        $correct += 1;
    }
    if ($resultado['pregunta4'] == 0){
        $wrong += 1;
    }
    else{
        $correct += 1;
    }
    if ($resultado['pregunta5'] == 0){
        $wrong += 1;
    }
    else{
        $correct += 1;
    }

    //Envío el puntaje total del jugador a la base de datos
    $enviar = "INSERT INTO jugadores (total_puntos) VALUES ('$total')";

    mysqli_query($conexion, $enviar);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <title>End</title>
</head>
<body>
    <!-- Muestro un mensaje al jugador que dice que completó el quiz -->
    <div class="center puntaje">
        <h1>Congratulations, <?php echo $_SESSION["jugador"] ?>, you have completed the quiz!</h1>
    </div>
    <br>
    <div class="center puntaje">
        <!-- Le muestro su puntaje total al jugador -->
        <h3>Your final score is: <?php echo $total ?></h3>
        <!-- Le muestro al jugador cuantas preguntas respondió bien y cuantas mal -->
        <h3>Questions answered correctly: <?php echo $correct ?></h3>
        <h3>Questions answered incorrectly: <?php echo $wrong ?></h3>
    </div>
    <br>
    <!-- Div para dejar bonito el botón -->
    <div class="next center">
        <!-- Botón para redirigir al jugador al archivo "cerrar.php" -->
        <a href="cerrar.php" type="button" class="center sombra1 btn btn-light btn-inicio">Return to menu</a>
    </div>  
</body>
</html>