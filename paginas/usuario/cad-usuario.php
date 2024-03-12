<?php
include('verifica_login.php');
?>
<?php
if(!isset($_POST['usuario']) || !isset($_POST['nome'])){
    header('Location: index.php?menuop=usuario');
    exit();
}

if ($_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=usuario');
    exit();
}
?>
<div class="container">
    <?php

    $usuario = $_POST['usuario'];
    $nome = $_POST['nome'];

    ?>

    <header class="mt-2 mb-2">
        <span class="fs-4">Cadastro de usuário</span>
    </header>

    <div>
        <form action="index.php?menuop=inserir-usuario" method="post">
            <div class="mb-3">
                <label class="form-label" for="usuario">Login</label>
                <input class="form-control" type="text" name="usuario" value="<?= $usuario ?>" pattern="(?!.*[._-]{2,})^[a-zA-Z0-9._-]{3,20}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" value="<?= $nome ?>" pattern="[A-Za-zÀ-ú ']+" required>
            </div>
            <div class="mb-3 col-3">
                <label class="form-label" for="novaSenha">Senha</label>
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
            <div class="mb-3 col-3">
                <label class="form-label" for="perfil">Perfil</label>
                <select class="form-control" name="perfil" id="perfil" value="" required>
                    <option selected value="">Perfil do usuário</option>
                    <option value="0">Usuário</option>
                    <option value="1">Administrador</option>
                </select>
            </div>
    </div>

    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <p><b>Administradores</b> podem cadastrar usuários, alterar e excluir quaisquer usuários, cadastrar agendamentos, alterar e excluir quaisquer agendamentos.</p>
        <hr>
        <p class="mb-0"><b>Usuários</b> podem alterar o seu próprio usuário (exceto o perfil), cadastrar agendamentos, alterar e excluir os seus próprios agendamentos.</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="mb-3">
        <input class="btn btn-light" type="submit" value="Adicionar" name="btnAdicionar">
    </div>
    </form>
</div>
</div>