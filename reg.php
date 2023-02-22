<?php
require "functions.php";
require "credentials.php";

$error = false;
$success = false;
$name = $email = "";
$data = date("Ymd");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["nome"]) && isset($_POST["email1"]) && isset($_POST["email2"]) && isset($_POST["senha1"]) && isset($_POST["senha2"])) {
    $conn = conectar();

    $name = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email = mysqli_real_escape_string($conn, $_POST["email1"]);
    $confirm_email = mysqli_real_escape_string($conn, $_POST["email2"]);
    $password = mysqli_real_escape_string($conn, $_POST["senha1"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["senha2"]);

    if ($password != $confirm_password || $email != $confirm_email) {
      $error_msg = "Senha ou Email não conferem com a confirmação.";
      $error = true;
    } else if ($name == "" || $password == "") {
      $error_msg = "Nome e Senha devem ser preenchidos";
      $error = true;
    } else {
      $password = md5($password);
      $sql = "SELECT * from users";
      $query_data = mysqli_query($conn, $sql)->fetch_all(MYSQLI_ASSOC);
      foreach ($query_data as $row) {
        if ($row["email"] == $email) {
          $error_msg = "Email já está cadastrado";
          $error = true;
          break;
        }
      }
      if (!$error) {
        $sql = "INSERT INTO users (username, email, senha, dt_cadastro) VALUES ('$name', '$email', '$password', '$data')";
        if (mysqli_query($conn, $sql)) {
          $success = true;
        } else {
          $error_msg = mysqli_error($conn);
          $error = true;
        }
      }
    }
  } else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/reg.css">
  <title>Registro</title>
</head>

<body>

  <div class="barra">
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php">Forum Bacana</a>
    </nav>
  </div>

  <?php if ($success) : ?>
    <h6 style="color:lightgreen;">Usuário criado com sucesso!</h3>
    <?php endif; ?>

    <?php if ($error) : ?>
      <h6 style="color:red;"><?php echo $error_msg; ?></h3>
      <?php endif; ?>

      <div id="container">

        <div id="box">
          <h1>Formulario de Registro</h1>
          <div class="form-group" id="entrada">
            <form action="reg.php" method="POST">
              E-mail <input type="email" name="email1" class="form-control" id="email1">
              confirmação de Email<input type="email" name="email2" class="form-control" id="email2">
              Nome de usuário: <input type="text" name="nome" class="form-control" id="nome">
              senha: <input type="password" name="senha1" class="form-control" id="senha1">
              confirmação de senha: <input type="password" name="senha2" class="form-control" id="senha2"><br>
              <input type="submit" value="Registrar" id="botao_registro" class="btn btn-danger btn-block">
              <a href="index.php" class="btn btn-success btn-block" id="botao_registro">Login</a>
            </form>
          </div>
        </div>
      </div>

</body>

</html>