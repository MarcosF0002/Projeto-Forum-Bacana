<?php
require "functions.php";
require "credentials.php";
require "acesso_negado.php";


if (isset($_GET['id']) && isset($_POST['resposta'])) {
  $texto = $_POST['resposta'];
  $topico = $_GET['id'];
  $usuario = $user_id;
  $data = date("Ymd");
  $hora = date("h:i:s");


  $conn = conectar();
  $sql = "SELECT * FROM comments WHERE post = $topico";
  $result = mysqli_query($conn, $sql);
  $linhas = mysqli_num_rows($result);
  $posicao = $linhas + 1;
  echo $posicao;

  $sql = "INSERT INTO comments
              (texto, post, usuario,data, hora, posicao) VALUES
              ('$texto',$topico, $usuario,'$data', '$hora', $posicao)";
  if (mysqli_query($conn, $sql)) {
    $success = true;
  } else {
    $error_msg = mysqli_error($conn);
    $error = true;
    echo "$error_msg";
    exit();
  }
  header("Location: post.php?id=$topico");
} else {
  echo "Erro ao enviar comentario! Tente denovo";
}
