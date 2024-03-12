<?php
include('verifica_login.php');
?>

<?php

// Se n existir a variável de consulta
if (!isset($_GET["usuario_id"])) {
    header('Location: index.php?menuop=usuario');
    exit();
}


$usuario_id = mysqli_real_escape_string($conexao, $_GET["usuario_id"]);
$sqlSecurity = "SELECT * FROM usuario WHERE usuario_id = '{$usuario_id}'";
$rs = mysqli_query($conexao, $sqlSecurity) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se n existir nenhum dado
if (mysqli_num_rows($rs) == 0) {
    header("Location: index.php?menuop=usuario");
    exit();
}

if ($_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=usuario');
    exit();
} else {
    $sql = "DELETE FROM usuario WHERE usuario_id = '{$usuario_id}'";
    mysqli_query($conexao, $sql) or die("Erro ao excluir registro. " . mysqli_error($conexao));
}
?>

<div class="container">


    <body>
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">
                <div class="text-center">
                    <h4>Usuário excluído com sucesso!</h4>
                    <form action="index.php?menuop=usuario" method="post">
                        <input class="btn btn-light mt-2" type="submit" value="Voltar">
                    </form>
                </div>
            </div>
        </div>


    </body>
</div>