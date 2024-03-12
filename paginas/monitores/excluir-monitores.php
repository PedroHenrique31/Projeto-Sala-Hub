<?php
include('verifica_login.php');
?>

<?php
if(!isset($_POST['idMonitor']) || $_SESSION['administrador'] != 1){
    header('Location: index.php?menuop=monitores');
    exit();
}

$idMonitor = mysqli_real_escape_string($conexao, $_POST["idMonitor"]);
$sqlSecurity = "SELECT * FROM tbmonitor WHERE idMonitor = '{$idMonitor}'";
$rs = mysqli_query($conexao, $sqlSecurity) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

$sql = "DELETE FROM tbmonitor WHERE idMonitor = '{$idMonitor}'";
mysqli_query($conexao, $sql) or die("Erro ao excluir registro. " . mysqli_error($conexao));

?>

<div class="container">
    <body>
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">
                <div>
                    <h4>Exclusão feita com sucesso!</h4>
                </div>
                <div class="text-center">
                    <form action="index.php?menuop=monitores" method="post">
                        <input class="btn btn-light mt-2" type="submit" value="Voltar">
                    </form>
                </div>
            </div>
        </div>
    </body>
</div>