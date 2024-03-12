<?php
include('verifica_login.php');
?>

<?php
if(!isset($_POST['idAgenda'])){
    header('Location: index.php?menuop=agendamento');
    exit();
}

$idAgenda = mysqli_real_escape_string($conexao, $_POST["idAgenda"]);
$sqlSecurity = "SELECT * FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
$rs = mysqli_query($conexao, $sqlSecurity) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

if ($dados["idUsuario"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=agendamento');
    exit();
} else {
    $sql = "DELETE FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
    mysqli_query($conexao, $sql) or die("Erro ao excluir registro. " . mysqli_error($conexao));
}
?>

<div class="container">
    <body>
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">
                <div>
                    <h4>Exclusão feita com sucesso!</h4>
                </div>
                <div class="text-center">
                    <form action="index.php?menuop=agendamento" method="post">
                        <input class="btn btn-light mt-2" type="submit" value="Voltar">
                    </form>
                </div>
            </div>
        </div>
    </body>
</div>