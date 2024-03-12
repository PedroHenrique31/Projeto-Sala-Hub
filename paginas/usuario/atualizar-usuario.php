<?php
include('verifica_login.php');
?>

<?php

if(!isset($_POST['usuario_id']) || !isset($_POST['usuario']) || !isset($_POST['nome']) || !isset($_POST['perfil'])){
    header('Location: index.php?menuop=usuario');
    exit();
}


// mysqli_real_escape_string serve para impedir que o usuário insira comandos diretos do sql nos campos
$usuario_id = mysqli_real_escape_string($conexao, $_POST["usuario_id"]);
$usuario = mysqli_real_escape_string($conexao, $_POST["usuario"]);
$nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
$perfil = mysqli_real_escape_string($conexao, $_POST["perfil"]);
if ($usuario_id != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=usuario');
    exit();
}

?>

<div class="mt-5 d-flex justify-content-center">
    <div class="rounded-4 p-4 border border-4 shadow-sm">

        <?php

        if ((!preg_match("/^(?!.*[._-]{2,})^[a-zA-Z0-9._-]{3,20}$/", $usuario)) || (!preg_match("/^[A-Za-zÀ-ú ']+$/", $nome))) {
            echo ("<div class='text-center'>
                <h4>O formato do login ou nome digitado é inválido. Tente novamente.</h4>
                </div>
                <div class='text-center'>
                <form action='index.php?menuop=editar-usuario&usuario_id=$usuario_id' method='post'>
                <input class='btn btn-light mt-2' type='submit' value='Voltar'>");
            exit();
        }

        if (($perfil == 1 && $_SESSION["administrador"] != 1) || ($perfil != 0 && $perfil != 1)) {
            $perfil = 0;
        }
        $sql = "UPDATE usuario SET 
        usuario = '{$usuario}',
        nome = '{$nome}',
        administrador = '{$perfil}'
        WHERE usuario_id = '{$usuario_id}'
        ";
        mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));

        echo "<h4>O cadastro do usuário foi atualizado com sucesso!</h4>";

        ?>

        <body>
            <form action="index.php?menuop=usuario" method="post">
                <div class="text-center">
                    <input class="btn btn-light mt-2" type="submit" value="Voltar">
            </form>
        </body>