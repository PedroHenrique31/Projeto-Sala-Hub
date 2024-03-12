<?php
include('verifica_login.php');
?>

<?php
if(!isset($_POST['idProjetos'])){
    header('Location: index.php?menuop=agendamento');
    exit();
}

$idProjetos = mysqli_real_escape_string($conexao, $_POST["idProjetos"]);

//Pega os dados do projeto com o ID dado
$sql = "SELECT * FROM tbprojetos WHERE idProjetos = {$idProjetos}";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
if (mysqli_num_rows($rs) == 0) {
    header("Location: index.php?menuop=projetos");
    exit();
}

// Se o usuário não for admin e nem autor do projeto
if(($_SESSION['usuario_id'] != $dados['usuarioIdProjetos']) && ($_SESSION['administrador'] != 1)){
    header("Location: index.php?menuop=projetos");
    exit();
}

//$visivelProjetos = $dados['visivelProjetos'];

$idProjetos = $dados['idProjetos'];

$sql = "DELETE FROM tbprojetos WHERE idProjetos = '{$idProjetos}'";


mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro


?>

<div class="container">
    <body>
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">
                <div>
                    <h4>Projeto deletado definitivamente!</h4>
                </div>
                <div class="text-center">
                    <form action="index.php?menuop=projetos" method="post">
                        <input class="btn btn-light mt-2" type="submit" value="Voltar">
                    </form>
                </div>
            </div>
        </div>
    </body>
</div>