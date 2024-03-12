<?php
include('verifica_login.php');
?>

<?php

if (!isset($_SESSION['administrador']) || !isset($_GET['idProjetos'])) {
    header('Location: index.php?menuop=projetos');
    exit();
}

if ($_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=projetos');
    exit();
}

$idProjetos = $_GET['idProjetos'];

$sql = "UPDATE tbprojetos SET visivelProjetos = 0 WHERE idProjetos = $idProjetos";
mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro

header('Location: index.php?menuop=projetos');
exit();

?>
