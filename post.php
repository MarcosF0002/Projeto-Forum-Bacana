<?php
require "functions.php";
require "credentials.php";
require "authenticate.php";
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

    // Obter o ID do post a partir da URL
    $post_id = $_GET['id'];

    // Conectar ao banco de dados
    $conn = conectar();

    // Selecionar a postagem
    $sql = "SELECT * FROM posts WHERE id='$post_id'";
    $result = mysqli_query($conn, $sql);

    // Verificar se a postagem existe
    if (mysqli_num_rows($result) == 0) {
        echo "Post não encontrado.";
        exit();
    }

    // Extrair os dados da postagem
    $post = mysqli_fetch_assoc($result);

    // Selecionar os comentários
    $sql = "SELECT * FROM comments WHERE post='$post_id'";
    $result = mysqli_query($conn, $sql);

    // Extrair os comentários
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <div class="list-group">
        <a style="border-top-left-radius: unset; border-top-right-radius: unset;" href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="display-4">Post:</h5>
            </div>
        </a>
        <a class="list-group-item list-group-item-action flex-column align-items-start">
            <div style="justify-content: flex-end!important;" class="d-flex w-100 justify-content-between">
                <small class="text-muted">Data: <?php echo $post['data']; ?> Hora: <?php echo $post['hora']; ?></p></small>
            </div>
            <h2><?php echo $post['titulo']; ?></h2>
            <h5>
                <p><?php echo $post['texto']; ?></p>
            </h5>
            <small href="perfil.php?id=<?php echo $post['user']; ?>">Autor: <?php
                                                                            $result = mysqli_query($conn, "SELECT * from users WHERE id=" . $post['user']);
                                                                            $linhas = mysqli_num_rows($result);
                                                                            while ($linhas = mysqli_fetch_assoc($result)) {
                                                                                echo $linhas['username'];
                                                                            }
                                                                            ?></small>
            <button style="font-size: 0.8rem; display: flex; margin-top: 4px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Responder</button>
            <hr class="my-4">

            <?php foreach ($comments as $comment) { ?>
                <small class="text-muted">Data: <?php echo $comment['data']; ?> Hora: <?php echo $comment['hora']; ?></p></small>
                <small href="perfil.php?id=<?php echo $comment['usuario']; ?>">Autor: <?php
                                                                                        $result = mysqli_query($conn, "SELECT * from users WHERE id=" . $comment['usuario']);
                                                                                        $linhas = mysqli_num_rows($result);
                                                                                        while ($linhas = mysqli_fetch_assoc($result)) {
                                                                                            echo $linhas['username'];
                                                                                        }
                                                                                        ?></small>
                <h5 class="text-muted"><?php echo $comment['texto']; ?></h5>
                <hr class="my-4">
            <?php } ?>
        </a>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Responder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="comment.php?id=<?php echo $post_id; ?>" method="post">
                        <div class="form-group">
                            <label for="texto" class="col-form-label">Comentário:</label>
                            <textarea class="form-control" id="texto" name="texto"></textarea>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>