<?php
include('verifica_login.php');
?>

<?php

if(!isset($_POST['usuario_id']) || !isset($_POST['novaSenha']) || !isset($_POST['confirmacaoSenha'])){
    header('Location: index.php?menuop=usuario');
    exit();
}

$usuario_id = mysqli_real_escape_string($conexao, $_POST["usuario_id"]);
$novaSenha = mysqli_real_escape_string($conexao, $_POST["novaSenha"]);
$confirmacaoSenha = mysqli_real_escape_string($conexao, $_POST["confirmacaoSenha"]);

if ($usuario_id != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=usuario');
    exit();
}

?>

<div class="mt-5 d-flex justify-content-center">
    <div class="rounded-4 p-4 border border-4 shadow-sm">

        <?php

        if ($novaSenha != $confirmacaoSenha) {
            echo ("<div class='text-center'>
            <span class='fs-4'>As senhas digitadas não conferem. Tente novamente.</span>
            </div>
            <div class='text-center'>
            <a class='btn btn-light mt-2' href='index.php?menuop=alterar-senha&usuario_id=$usuario_id'>Voltar</a>");
            exit();
        }

        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,20}$/", $novaSenha)) {
            echo ("<div class='text-center'>
            <h4>A nova senha deve ter de 8 a 20 caracteres e conter pelo menos 1 letra maiúscula, 1 letra minúscula e 1 dígito. Tente novamente.</h4>
            </div>
            <div class='text-center'>
            <a class='btn btn-light mt-2' href='index.php?menuop=alterar-senha&usuario_id=$usuario_id'>Voltar</a>");
            exit();
        }

        $sql = "UPDATE usuario SET senha = md5('{$novaSenha}') WHERE usuario_id = '{$usuario_id}'";

        mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));

        echo "<h4>A senha foi atualizada com sucesso!</h4>"

        ?>

        <body>
            <form action="index.php?menuop=usuario" method="post">
                <div class="text-center">
                    <input class="btn btn-light mt-2" type="submit" value="Voltar">
            </form>
        </body>