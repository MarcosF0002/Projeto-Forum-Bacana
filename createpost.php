<?php
require "functions.php";
require "credentials.php";
require "acesso_negado.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>Adicionar topico</title>
</head>

<body>

  <div class="barra">
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="home.php">Forum Bacana</a>
      <a class="navbar-text" href="perfil.php?id=<?php echo $_SESSION['id']; ?>">Perfil</a>
      <a class="navbar-text" href="createpost.php">Novo Post</a>
      <a class="navbar-text" href="logout.php">Logout</a>

    </nav>
  </div>
  <form style="margin-top: 10px;" action="post_input.php" method="POST">
    <div class="form-group">
      <label for="exampleInputEmail1">Título:</label>
      <input type="text" class="form-control" name="titulo" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Conteúdo:</label>
      <input type="text" class="form-control" name="texto" id="exampleInputPassword1">
    </div>
    <button style="margin-left: 9px;" type="submit" class="btn btn-primary">Enviar</button>
  </form>
  <hr class="my-4">

</body>

</html>