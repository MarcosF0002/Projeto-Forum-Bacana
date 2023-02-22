<?php
require "acesso_negado.php";
require_once "credentials.php";
require "functions.php";
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

    <title>Home</title>
</head>

<body>
    <div class="barra">
        <nav class="navbar navbar-dark" style="background-color: #3c3c3c;">
            <a class="navbar-brand" href="home.php">Forum Bacana</a>
            <a class="navbar-text" href="perfil.php?id=<?php echo $_SESSION['id']; ?>">Perfil</a>
            <a class="navbar-text" href="createpost.php">Novo Post</a>
            <a class="navbar-text" href="logout.php">Logout</a>
        </nav>
    </div>

    <?php
    /// Preparando para mostrar todos os posts
    $inicio = 0;
    $topicos_por_pagina = 10;
    $conn = conectar();
    $sql = "SELECT * FROM posts ORDER BY data DESC LIMIT $inicio, $topicos_por_pagina"; // ordenando por dt mais recente
    $sql = "SELECT COUNT(*) as total FROM posts";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];

    $result = mysqli_query($conn, $sql);

    $topicos_por_pagina = 10;
    $num_paginas = ceil($total / $topicos_por_pagina);

    $pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $inicio = ($pagina_atual - 1) * $topicos_por_pagina;

    $sql = "SELECT * FROM posts LIMIT $inicio, $topicos_por_pagina";
    $result = mysqli_query($conn, $sql);

    while ($linhas = mysqli_fetch_assoc($result)) {
        $id[] = $linhas['id'];
        $titulo[] = $linhas['titulo'];
        $texto[] = $linhas['texto'];
        $usuario[] = $linhas['user'];
        $data[] = $linhas['data'];
        $hora[] = $linhas['hora'];
    }

    $z = 0;
    if (isset($id) && is_array($id) && count($id) > 0) {

        while ($z < count($id)) {

            $sql2 = "SELECT username FROM users WHERE id=$usuario[$z]";
            if ($result2 = mysqli_query($conn, $sql2)) {
                while ($linhas2 = mysqli_fetch_assoc($result2)) {
                    $autor[$z] = $linhas2['username'];
                }
            }
            $z++;
        }
    }
    ?>

    <div class="list-group">
        <a class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="display-4">Postagens:</h5>
            </div>
        </a>
        <?php
        //Só mostra posts contidos na variavel $id, não mostra paginas sem posts
        if (isset($id) && is_array($id) && count($id) > 0) {
            $a = 0;
            while ($a < count($id)) { ?>
                <a href="post.php?id=<?php echo $id[$a] ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?php echo $titulo[$a]; ?></h5>
                        <small class="text-muted">Data: <?php echo $data[$a]; ?></small>
                    </div>
                    <p style="justify-content: left;" class="mb-1"><?php echo $texto[$a]; ?></p>
                    <small class="text-muted">Autor: <?php echo $autor[$a]; ?></small>
                </a>
        <?php $a++;
            }
        } ?>
    </div>

    <!-- Cria pagina de navegação com 10 posts cada -->
    <nav aria-label="Page navigation example" style="margin-top: 10px;">
        <ul class="pagination justify-content-center">
            <?php
            $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 1;
            $pagina_proxima = ($pagina_atual < $num_paginas) ? $pagina_atual + 1 : $num_paginas;
            ?>
            <li class="page-item"><a class="page-link" href="home.php?pagina=<?php echo $pagina_anterior; ?>">Anterior</a></li>
            <?php
            for ($i = 1; $i <= $num_paginas; $i++) {
                $class = ($pagina_atual == $i) ? "active" : "";
                echo "<li class='page-item $class'><a class='page-link' href='home.php?pagina=$i'>$i</a></li>";
            }
            ?>
            <li class="page-item"><a class="page-link" href="home.php?pagina=<?php echo $pagina_proxima; ?>">Próximo</a></li>
        </ul>
    </nav>


    </div>
</body>

</html>