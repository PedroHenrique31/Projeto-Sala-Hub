<?php
    include("config.php");

    // Variável para conectar ao servidor contendo tabela SQL
    $conexao = mysqli_connect(SERVIDOR, USUARIO, SENHA, BANCO) or die('Erro na conexão com o servidor' . mysqli_connect_error());
    
?>