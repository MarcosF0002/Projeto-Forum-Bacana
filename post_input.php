<?php
require "functions.php";
require "credentials.php";
require "authenticate.php";

if (!empty($_POST['titulo']) && !empty($_POST['texto'])) {
    $conn = conectar();
    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $texto = mysqli_real_escape_string($conn, $_POST["texto"]);
    $erro = false;
    $id = $user_id;

    $data = date("Ymd");
    $hora = date("h:i:s");
    $sql = "INSERT INTO posts (titulo, texto, user, data, hora) VALUES ('$titulo', '$texto', '$id', '$data', '$hora') ";
    if (!mysqli_query($conn, $sql)) {
        $error_msg = mysqli_error($conn);
        $error = true;
        echo $error_msg;
    }
} else {
    $erro = true;
}
$sql = "SELECT * FROM posts WHERE (titulo='$titulo' and texto='$texto' and user='$id' and data='$data')";
if ($result = mysqli_query($conn, $sql)) {
    $linhas = mysqli_num_rows($result);
}

if ($linhas != 0) {
    while ($linhas = mysqli_fetch_assoc($result)) {
        $titulo = $linhas['titulo'];
        $texto = $linhas['texto'];
        $id_posts = $linhas['id'];
    }
}
if (!$erro)
    header("Location: post.php?id=$id_posts");
