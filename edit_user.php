<?php
require "acesso_negado.php";
require_once "credentials.php";
require "functions.php";

$id = $_GET['id'];

$conn = conectar();
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $senha = $row['senha'];
    $email = $row['email'];
} else {
    echo "Usuário não encontrado";
    exit;
}

//Recebe do form itens editados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username='$username', senha='$senha', email='$email' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: perfil.php?id=$id");
        echo "Dados editados com sucesso";
        $sucess =  true;
    } else {
        echo "Erro ao editar dados do usuário : " . mysqli_error($conn);
        $erro = true;
    }
} else {
    // Seleciona os dados do usuário a serem editados
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $senha = $row['senha'];
        $email = $row['email'];
    } else {
        echo "Usuário não encontrado";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Edição</title>
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
    <div class="jumbotron">
        <form action="edit_user.php?id=<?php echo $_SESSION['id']; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="username">Nome:</label>
            <input type="text" name="username" value="<?php echo $username; ?>"><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" value="<?php echo $senha; ?>"><br>
            <label for="email">E-mail:</label>
            <input type="email" name="email" value="<?php echo $email; ?>"><br>
            <input type="submit" value="Atualizar" class="btn btn-success btn-block" style="font-size: 17px; width: 130px;">
            <a href="perfil.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-danger btn-block" style="font-size: 17px; width: 130px;">Cancelar</a>
        </form>
    </div>

</body>

</html>