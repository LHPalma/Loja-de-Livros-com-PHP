<?php

@include 'config.php';

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {

        $message[] = 'Usuário já existe!';
    } else {

        if ($pass != $cpass) {
            $message[] = 'As senhas não batem!';
        } else {
            mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
            $message[] = 'Registrado com sucesso!';
            header('location: login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="Pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Loja de Livros</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- css customizado -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
                <div class="message">
                    <span>' . $message . '</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
            ';
        }
    }
    ?>

    <div class="form-container">
        <form action="" method="post">
            <h3>Registrar-se</h3>
            <input type="text" name="name" placeholder="Digite o seu nome" required class="box">
            <input type="email" name="email" placeholder="Digite o seu email" required class="box">
            <input type="password" name="password" placeholder="Digite a sua senha" required class="box">
            <input type="password" name="cpassword" placeholder="Confirme a sua senha" required class="box">
            <select name="user_type" class="box">
                <option value="user">Usuário</option>
                <option value="admin">Administrador</option>
            </select>
            <input type="submit" name="submit" value="Registrar-se agora" class="btn">
            <p>Já possui uma conta? <a href="login.php">Fazer login</a></p>
        </form>
    </div>
</body>

</html>