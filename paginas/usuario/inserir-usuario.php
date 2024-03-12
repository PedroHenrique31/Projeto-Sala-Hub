<?php
include('verifica_login.php');
?>
<?php

// Se n existir a variável de consulta
if(!isset($_POST["usuario"]) || !isset($_POST["nome"]) || !isset($_POST["novaSenha"]) || !isset($_POST["perfil"])){
    header('Location: index.php?menuop=usuario');
    exit();
}

// mysqli_real_escape_string serve para impedir que o usuário insira comandos diretos do sql nos campos
$usuario = mysqli_real_escape_string($conexao, $_POST["usuario"]);
$nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
$novaSenha = mysqli_real_escape_string($conexao, $_POST["novaSenha"]);
$confirmacaoSenha = mysqli_real_escape_string($conexao, $_POST["confirmacaoSenha"]);
$perfil = mysqli_real_escape_string($conexao, $_POST["perfil"]);

if ($_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=usuario');
    exit();
}

?>

<form action="index.php?menuop=cad-usuario" method="post">
    <input type="hidden" name="usuario" value="<?= $usuario ?>">
    <input type="hidden" name="nome" value="<?= $nome ?>">
    <input type="hidden" name="perfil" value="<?= $perfil ?>">
</form>

<div class="mt-5 d-flex justify-content-center">
    <div class="rounded-4 p-4 border border-4 shadow-sm">

        <?php

        if ((!preg_match("/^(?!.*[._-]{2,})^[a-zA-Z0-9._-]{3,20}$/", $usuario)) || (!preg_match("/^[A-Za-zÀ-ú ']+$/", $nome))) {
            echo ("<div class='text-center'>
                <h4>O formato do login ou nome digitado é inválido. Tente novamente.</h4>
                </div>
                <div class='text-center'>
                <form action='index.php?menuop=cad-usuario' method='post'>
                <input class='btn btn-light mt-2' type='submit' value='Voltar'>
                <input type='hidden' name='usuario' value='$usuario'>
                <input type='hidden' name='nome' value='$nome'>");
            exit();
        }

        if ($novaSenha != $confirmacaoSenha) {
            echo ("<div class='text-center'>
                <h4>As senhas digitadas não conferem. Tente novamente.</h4>
                </div>
                <div class='text-center'>
                <form action='index.php?menuop=cad-usuario' method='post'>
                <input class='btn btn-light mt-2' type='submit' value='Voltar'>
                <input type='hidden' name='usuario' value='$usuario'>
                <input type='hidden' name='nome' value='$nome'>");
            exit();
        }

        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,20}$/", $novaSenha)) {
            echo ("<div class='text-center'>
                <h4>A nova senha deve ter de 8 a 20 caracteres e conter pelo menos 1 letra maiúscula, 1 letra minúscula e 1 dígito. Tente novamente.</h4>
                </div>
                <div class='text-center'>
                <form action='index.php?menuop=cad-usuario' method='post'>
                <input class='btn btn-light mt-2' type='submit' value='Voltar'>
                <input type='hidden' name='usuario' value='$usuario'>
                <input type='hidden' name='nome' value='$nome'>");
            exit();
        }

        $sql = "INSERT INTO usuario (usuario, nome, senha, administrador) VALUES ('{$usuario}', '{$nome}', md5('{$novaSenha}'), '{$perfil}')";
        mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));

        echo "<h4>O usuário foi cadastrado com sucesso!</h4>";

        ?>

        <body>
            <form action="index.php?menuop=usuario" method="post">
                <div class="text-center">
                    <input class="btn btn-light mt-2" type="submit" value="Voltar">
            </form>
        </body>
    </div>