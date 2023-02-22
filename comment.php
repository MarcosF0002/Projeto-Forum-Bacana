<?php
require "functions.php";
require "credentials.php";
require "acesso_negado.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Post</title>
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

  <?php
  $id = $_GET['id'];
  $conn = conectar();
  $sql = "SELECT * FROM posts WHERE (id=$id)";
  if ($result = mysqli_query($conn, $sql)) {
    $linhas = mysqli_num_rows($result);
  }
  if ($linhas != 0) {
    while ($linhas = mysqli_fetch_assoc($result)) {
      $titulo = $linhas['titulo'];
      $texto = $linhas['texto'];
    }
  }
  ?>

  <div class="list-group">
    <a style="border-top-left-radius: unset; border-top-right-radius: unset;" href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="display-4">Post:</h5>
      </div>
    </a>

    <a class="list-group-item list-group-item-action flex-column align-items-start">
      <h2><?php echo $titulo; ?></h2>
      <h5><?php echo $texto; ?></h5>
      <button style="font-size: 0.8rem; display: flex; margin-top: 4px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Responder</button>
      <hr class="my-4">
      <p>Nâo existem comentario para este post!</p>
    </a>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Resposta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div style="margin-top: 1rem;" class="form-group">
            <form id="mainForm" action="resposta.php?id=<?php echo $id; ?>" method="POST">
              <input style="width: 450px; height: 150px; margin-left: 24px; border-radius: 0.25rem;" type="text" name="resposta" id="resposta">
              <input style="margin-left: 417px; margin-top: 10px;" id="bt-comment" class="btn btn-primary" type="submit" value="Enviar">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    let form = document.querySelector("#mainForm");
    let input = document.querySelector("#resposta");
    input.value = '<?php echo $_POST["texto"]; ?>';
    $(form).submit();
  </script>
</body>

</html>