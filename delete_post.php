<?php
require "functions.php";
require "acesso_negado.php";

$id = $_GET['id'];
if ($id != "") {
    $conn = conectar();
    $sql = "SELECT * FROM posts WHERE id='$id'";
    if ($result = mysqli_query($conn, $sql)) {
        $linhas = mysqli_num_rows($result);
    }
    if ($linhas != 0) {
        while ($linhas = mysqli_fetch_assoc($result)) {
            $usuario = $linhas['user'];
        }
    } else {
        $erro = true;
        $erro_msg = "topico não encotrado.";
    }
    if ($user_id == $usuario) {
        $sql = "DELETE FROM comments WHERE post=$id;";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM posts WHERE id=$id;";
        mysqli_query($conn, $sql);
    } else {
        $erro_msg = "voce so pode deletar posts criado por voce mesmo";
        $erro = true;
    }
} else {
    $erro_msg = "Voce precisa passar um post para ser deletado.";
    $erro = true;
}
header("Location: perfil.php?id=$id");
