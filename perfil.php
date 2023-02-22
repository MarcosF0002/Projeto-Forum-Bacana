<?php
require "acesso_negado.php";
require_once "credentials.php";
require "functions.php";
$i = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Perfil <?php echo $id; ?></title>
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
    <div class="container">
        <p>
            <?php
            if ($user_id) {
                $conn = conectar();

                $pesquisapub = mysqli_query($conn, "SELECT * FROM posts WHERE user='" . $user_id . "'");
                $linhas1 = mysqli_num_rows($pesquisapub);

                $pesquisa = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $user_id . "'");
                $linhas = mysqli_num_rows($pesquisa);

                if (mysqli_num_rows($pesquisa) != 0) {
                    $linha = mysqli_fetch_assoc($pesquisa);
                    $user = $linha['username'];
                    $cadastro = $linha['dt_cadastro'];
                    $email = $linha['email'];
                    $n_publi = $linhas1;

                    while ($linha1 = mysqli_fetch_array($pesquisapub)) {
                        $lista_usuario[] = $linha1['titulo'];
                        $lista_usuario_id[] = $linha1['id'];
                    }
                } else {
                    echo "Erro";
                }

                desconectar($conn);
            } else {
                header("Location: home.php");
            }
            ?>
        <div class="jumbotron">
            <h1 style="display: inline-block;" class="display-4"><?= $user ?></h1>
            <p style="display: block;" class="lead">Membro desde: <?= $cadastro ?></p>
            <p style="display: block;" class="lead">Email: <?= $email ?></p>
            <a href="edit_user.php?id=<?php echo $_SESSION['id']; ?>" role="button">Editar dados de usuário</a>
            <hr class="my-4">
            <h2 style="display: inline-block;"><?= $n_publi ?></h1>
                <h2 style="display: inline-block;">Posts</h2>

                <?php
                if (isset($lista_usuario_id) && is_array($lista_usuario_id)) {
                    foreach ($lista_usuario_id as $key => $value) { ?>
                        <div style="margin-top: 5px;" class="">
                            <h6 style="display: inline-flex;"><?= $lista_usuario[$key] ?></h6>
                            <a style="background: red; font-size: 0.7rem; display: unset; width: 40px; height: 25px;" class="btn btn-primary btn-lg" href="delete_post.php?id=<?= $value ?>" role="button">Deletar</a><br>
                        </div><?php }
                        } ?>
        </div>
    </div>

</body>

</html>