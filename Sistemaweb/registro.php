<?php
 
include('config.php');
session_start();
 
if (isset($_POST['register'])) {
 
    $username = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
 
    $query = $connection->prepare("SELECT * FROM users WHERE EMAIL=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
 
    if ($query->rowCount() > 0) {
        echo '<p class="error">La dirección de correo electronico ya esta registrado!</p>';
    }
 
    if ($query->rowCount() == 0) {
        $query = $connection->prepare("INSERT INTO users(USERNAME,PASSWORD,EMAIL) VALUES (:username,:password_hash,:email)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $result = $query->execute();
 
        if ($result) {
            echo '<p class="success">Registrado correctamente!</p>';
            header("Location: home.php");
        } else {
            echo '<p class="error">Ha ocurrido un error!</p>';
            header("Location: registro.php");
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
    <title>Registro</title>
</head>
<body>
    
<div class="login">
<h1>Registro</h1>
<form name="register" action = "" method="post">
    <input type="text" name="usuario" id = "usuario" placeholder="Usuario" required="required" />
    <input type="text" name="email" id = "email" placeholder="Correo electronico" required="required" />
    <input type="password" name="password" id = "password" placeholder="Contraseña" required="required" />
    <button type="submit" name="register" class="btn btn-primary btn-block btn-large">Registrarse</button>
</form>
</div>


</body>
</html>