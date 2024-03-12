<?php
include('verifica_login.php');
?>

<?php

// Se n existir a variável de consulta
if (!isset($_GET["usuario_id"])) {
    header('Location: index.php?menuop=usuario');
    exit();
}

$usuario_id = $_GET["usuario_id"];

$sql = "SELECT * FROM usuario WHERE usuario_id = {$usuario_id}";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se n existir nenhum dado
if (mysqli_num_rows($rs) == 0) {
    header("Location: index.php?menuop=usuario");
    exit();
}

if ($dados["usuario_id"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=usuario');
    exit();
}
?>

<div class="container mt-3">
    <header>
        <span class="fs-3">Editar Usuário</span>
    </header>

    <div>
        <div class="d-flex justify-content-end">
            <a href="index.php?menuop=alterar-senha&usuario_id=<?= $dados['usuario_id'] ?>" class="btn btn-light">Alterar Senha</a>
        </div>
        <form action="index.php?menuop=atualizar-usuario" method="post">
            <div class="mt-2 mb-3">
                <label class="form-label" for="usuario">Login</label>
                <input class="form-control" type="text" name="usuario" value="<?= $dados["usuario"] ?>" pattern="(?!.*[._-]{2,})^[a-zA-Z0-9._-]{3,20}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" value="<?= $dados["nome"] ?>" pattern="[A-Za-zÀ-ú ']+" required>
            </div>
            <div class="mb-3 col-3">
                <label class="form-label" for="perfil">Perfil</label>
                <select class="form-control" name="perfil" id="perfil" required>
                    <?php if ($_SESSION['administrador'] != 1) {
                    ?><option selected value="0">Usuário</option>
                    <?php } else { ?>
                        <option value="">Perfil do Usuário</option>
                        <?php if ($dados['administrador'] == 0) { ?><option selected value="0">Usuário</option><?php } else { ?><option value="0">Usuário</option>
                        <?php }
                                                                                                            if ($dados['administrador'] == 1) { ?><option selected value="1">Administrador</option><?php } else { ?><option value="1">Administrador</option><?php } ?>
                    <?php } ?>
                </select>
            </div>
            
            <div class="d-flex">
                <input type="hidden" name="usuario_id" value="<?= $dados["usuario_id"] ?>">
            </div>
            <div class="mt-4 d-flex">
                <input class="btn btn-light mt-2" type="submit" value="Atualizar" name="btnAtualizar">
            </div>
        </form>
    </div>
</div>