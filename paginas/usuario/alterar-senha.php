<?php
include('verifica_login.php');
?>

<?php 
if(!isset($_GET['usuario_id'])){
    header('Location: index.php?menuop=usuario');
    exit();
}

$usuario_id = $_GET["usuario_id"];

    $sql = "SELECT * FROM usuario WHERE usuario_id = {$usuario_id}";
    $rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
    $dados = mysqli_fetch_assoc($rs);
    if ($dados["usuario_id"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
        header('Location: index.php?menuop=usuario');
        exit();
    }
    
?>

<div class="container mt-3">
    <header class="mb-2">
        <span class="fs-3">Alterar Senha</span>
    </header>

    <body>
        <form action="index.php?menuop=atualizar-senha" method="post">
            <div class="mb-3 col-3">
                <label class="form-label" for="novaSenha">Nova senha</label>
                <input class="form-control" type="password" name="novaSenha" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,20}$" required>
            </div>
            <div id="passwordHelpBlock" class="form-text mb-3">
                Sua senha deve ter de 6 a 20 caracteres e conter pelo
                <br>menos 1 letra maiúscula, 1 letra minúscula e 1 dígito.
                <br>Você também pode inserir caracteres especiais.
            </div>
            <div class="mb-3 col-3">
                <label class="form-label" for="confirmacaoSenha">Confirmar senha</label>
                <input class="form-control" type="password" name="confirmacaoSenha" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,20}$" required>
            </div>

            <div class="mt-4 d-flex">
                <input class="btn btn-light" type="submit" value="Atualizar">
            </div>
            <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
    </body>