<?php
 
include('config.php');
session_start();
 
if (isset($_POST['login'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $query = $connection->prepare("SELECT * FROM users WHERE USERNAME=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
 
    $result = $query->fetch(PDO::FETCH_ASSOC);
 
    if (!$result) {
        echo '<p class="error">Usuario o contraseña incorrecto!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id'];
            echo '<p class="success">Has iniciado sesión!</p>';

            header("Location: home.php");
        } else {
            echo '<p class="error">Usuario o contraseña incorrecto!</p>';
        }
    }
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Document</title>
</head>
<body>

<div class="login">
	<h1>Iniciar sesión</h1>
    <form name = "login" action = "" method="post">
    	<input type="text" name="username" id = "username" placeholder="Usuario" required="required" />
        <input type="password" name="password" id = "password" placeholder="Contraseña" required="required" />
        <button type="submit" name = "login" class="btn btn-primary btn-block btn-large">Iniciar sesión.</button>
        <a href="registro.php" class = "eregistro">¿No tienes una cuenta?</a>
    </form>
</div>
</body>

</html>