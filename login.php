
<?php
session_start();
require "functions.php";
require "index.php";
require "authenticate.php";
$error = false;
$success = false;
$email = $_POST['email'];
$senha = $_POST['senha'];
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $conn = conectar();
    $sql = "SELECT * FROM users WHERE email='" . $email . "'";
    if (mysqli_query($conn, $sql)) {
        $sucess = true;
    } else {
        $error_msg = mysqli_error($conn);
        $error = true;
    }
    if ($result = mysqli_query($conn, $sql)) {
        $linhas = mysqli_num_rows($result);
    }

    if ($linhas != 0) {
        while ($linhas = mysqli_fetch_assoc($result)) {
            $bd_email = $linhas['email'];
            $bd_senha = $linhas['senha'];
            $bd_username = $linhas['username'];
            $bd_id = $linhas['id'];
        }
        if (md5($senha) == $bd_senha) {
            mysqli_free_result($result);
            $_SESSION["username"] = $bd_username;
            $_SESSION["id"] = $bd_id;
            $_SESSION["email"] = $bd_email;
            header("Location: home.php");
        } else {
            echo "Senha incorreta.";
            mysqli_free_result($result);
            header("Location: index.php?a=1");
        }
    } else {
        echo "Email não encontrado";
        mysqli_free_result($result);
        header("Location: index.php?a=2");
    }
} else {
    echo "Email e senha devem ser preenchidos.";
    header("Location: index.phpa=3");
}

desconectar($conn);
?>  

