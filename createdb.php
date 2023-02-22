<?php
require 'credentials.php';
require 'functions.php';
try {
    $conn = mysqli_connect($servername, $username, $password);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error() . date("Y-m-d H:i:s"));
    }
    $sql = "CREATE DATABASE $dbname";
    if (mysqli_query($conn, $sql)) {
        error_log("Banco de dados criado com sucesso!" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    } else {
        error_log(
            "Erro ao criar o banco de dados: " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n",
            3,
            "database.log"
        );
    }
    $sql = "USE $dbname";
    if (mysqli_query($conn, $sql)) {
        error_log("base de dados carregada" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    } else {
        error_log("Erro ao usar a base de dados " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    }

    $sql = "CREATE TABLE users(
    id int(6) AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    senha varchar(999) NOT NULL,
    email varchar(60) NOT NULL UNIQUE KEY,
    dt_cadastro date NOT NULL,
    n_publ INT
);";
    if (mysqli_query($conn, $sql)) {
        error_log("Tabela users criada com sucesso!" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    } else {
        error_log("Erro na criação do banco: " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    }

    $sql = "CREATE TABLE posts (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(999) NOT NULL,
    texto VARCHAR(999) NOT NULL,
    user INT(6),
    data DATE NOT NULL,
    hora char(8) NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (user) REFERENCES users(id)
);";

    if (mysqli_query($conn, $sql)) {
        error_log("Tabela posts criada com sucesso!" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    } else {
        error_log("Erro na criação do banco: " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    }

    $sql = "CREATE TABLE comments (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    texto VARCHAR(999) NOT NULL,
    post INT(6) NOT NULL,
    usuario INT(6) NOT NULL,
    data DATE NOT NULL,
    hora char(8) NOT NULL,
    posicao int NOT NULL,
    CONSTRAINT fk_post FOREIGN KEY (post) REFERENCES posts(id)
    
);";
    if (mysqli_query($conn, $sql)) {
        error_log("Tabela comments criada com sucesso!" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    } else {
        error_log("Erro na criação do banco: " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    }

    $sql = "INSERT INTO users (username, senha, email, dt_cadastro, n_publ) 
        VALUES ('usuario', 'admin', 'usuario@a.com', NOW(), 0)";
    if (mysqli_query($conn, $sql)) {
        error_log("Usuário inserido com sucesso!" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    } else {
        error_log("Erro ao inserir usuário: " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
    }


    $titulos = array(
        "Os princípios do desenvolvimento web responsivo",
        "Como criar um site acessível",
        "10 boas práticas de design para desenvolvimento web",
        "Por que as animações são importantes no desenvolvimento web",
        "As melhores ferramentas para testar a performance do seu site",
        "O impacto do SEO no desenvolvimento de websites",
        "Dicas para tornar seu site mais rápido",
        "As tendências mais recentes em desenvolvimento web",
        "Como melhorar a experiência do usuário no seu site",
        "As melhores práticas para desenvolvimento web seguro"
    );

    $frases = array(
        "O desenvolvimento web responsivo é essencial para garantir uma experiência positiva do usuário em dispositivos móveis.",
        "Um site acessível é aquele que pode ser utilizado por todas as pessoas, independentemente de suas habilidades físicas ou cognitivas.",
        "O design de um site é fundamental para a experiência do usuário e pode impactar diretamente na conversão.",
        "As animações podem ser usadas para guiar a atenção do usuário e tornar a experiência de navegação mais agradável.",
        "Testar a performance do seu site é importante para garantir uma boa experiência do usuário e melhorar a sua posição nos resultados de busca.",
        "O SEO pode impactar diretamente na visibilidade do seu site nos resultados de busca e atrair mais visitantes.",
        "Um site rápido é essencial para manter os visitantes engajados e melhorar a sua posição nos resultados de busca.",
        "As tendências em desenvolvimento web estão em constante mudança, é importante ficar atualizado para criar sites modernos e atrativos.",
        "A experiência do usuário é um dos fatores mais importantes para o sucesso de um site, é essencial criar um ambiente fácil de usar e intuitivo.",
        "A segurança do seu site é essencial para proteger seus dados e os dados dos seus usuários, é importante seguir as melhores práticas de desenvolvimento seguro."
    );


    for ($i = 1; $i <= 21; $i++) {
        $titulo = $titulos[array_rand($titulos)];
        $frase = $frases[array_rand($frases)];
        $sql = "INSERT INTO posts (titulo, texto, user, data, hora) 
                VALUES ('$titulo', '$frase', 1, NOW(), NOW())";
        if (mysqli_query($conn, $sql)) {
            error_log("Post $i inserido com sucesso!" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
        } else {
            error_log("Erro ao inserir post $i: " . mysqli_error($conn) . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
        }
    }
    echo "<div style='position:absolute;color:'darkgray''>Sucesso!</div>";
    desconectar($conn);
} catch (Exception $e) {
    error_log("$e" . date("Y-m-d H:i:s") . "\r\n", 3, "database.log");
}
