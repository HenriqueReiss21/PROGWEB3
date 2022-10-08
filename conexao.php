<?php

$user = "adminprogweb"; // Para que o código seja funcional, é preciso criar no phpmyadmin o usuário adminprogweb, com a senha ProgWeb3
$pass = "ProgWeb3";
$db = "progweb3"; // É necessário criar um banco de dados com o nome progweb3 e, após isso, importar o arquivo progweb3.sql, que contém as tabelas e valores necessários
$conn = mysqli_connect("localhost", $user, $pass, $db);
if ($conn->connect_errno){
    die("Erro de conexão" . $conn->connect_error); //Se a conexao falhar, vai mandar uma msg de erro
} 

?>
