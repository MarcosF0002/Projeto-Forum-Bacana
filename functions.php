<?php
require "credentials.php";
if (!function_exists("conectar")) {
    function conectar()
    {
        global $servername, $username, $dbname, $password;
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return ($conn);
    }
}
if (!function_exists('desconectar')) {
    function desconectar($conn)
    {
        mysqli_close($conn);
    }
}
