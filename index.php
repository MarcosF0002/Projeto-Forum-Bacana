<?php
include_once "createdb.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="styles\index2.css">
  <title>Login</title>
</head>

<body>
  <div class="barra">
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="home.php">Forum Bacana</a>
    </nav>
  </div>
  <?php
  $login_error_msg;
  if (isset($_GET["a"])) {
    if ($_GET["a"] == "1") {
      $login_error_msg = "Senha incorreta.";
    } else if ($_GET["a"] == "2") {
      $login_error_msg = "Email não encontrado";
    } else if ($_GET["a"] == "3") {
      $login_error_msg = "Email e senha devem ser preenchidos.";
    }
    echo "<div style='color:red;position:absolute'>$login_error_msg</div>";
  }
  ?>
  <div id="container">
    <div id="box">
      <br>
      <h1>Login</h1>
      <div class="form-group" id="entrada">
        <form action="login.php" method="POST">
          E-mail:<input type="email" name="email" id="email" class="form-control"><br>
          Senha:<input type="password" value="" class="form-control" name="senha" id="senha"><br>
          <input type="button" value="Login" class="btn btn-danger btn-block" id="login_botao"><br>
          <a href="reg.php" class="btn btn-success btn-block" id="botao_registro">Registrar</a>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="js/login.js"></script>
</body>

</html>