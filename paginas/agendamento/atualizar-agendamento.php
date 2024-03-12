<?php
    include('verifica_login.php');
?>

<?php
if(!isset($_POST['idAgenda']) || !isset($_POST['nomeAgenda']) || !isset($_POST['atividadeAgenda']) || 
!isset($_POST['cursoAgenda']) || !isset($_POST['bancadaTechAgenda']) || !isset($_POST['dataAgenda'])){
    header('Location: index.php?menuop=agendamento');
    exit();
}
?>
<header>
    <h3>
        Atualizar Agendamento
    </h3>  
</header>

    <?php
        // mysqli_real_escape_string serve para impedir que o usuário insira comandos diretos do sql nos campos
        $idAgenda = mysqli_real_escape_string($conexao, $_POST["idAgenda"]);
        $nomeAgenda = mysqli_real_escape_string($conexao, $_POST["nomeAgenda"]);
        $atividadeAgenda = mysqli_real_escape_string($conexao, $_POST["atividadeAgenda"]);
        $cursoAgenda = mysqli_real_escape_string($conexao, $_POST["cursoAgenda"]);
        $bancadaTechAgenda = mysqli_real_escape_string($conexao, $_POST["bancadaTechAgenda"]);
        $dataAgenda = mysqli_real_escape_string($conexao, $_POST["dataAgenda"]);
        $sql = "UPDATE tbagenda SET 
        nomeAgenda = '{$nomeAgenda}',
        atividadeAgenda = '{$atividadeAgenda}',
        cursoAgenda = '{$cursoAgenda}',
        bancadaTechAgenda = '{$bancadaTechAgenda}',
        dataAgenda = '{$dataAgenda}'
        WHERE idAgenda = '{$idAgenda}'
        ";
        mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));

        echo "O registro foi atualizado com sucesso!";
        
    ?>

<body>
    <form action="index.php?menuop=agendamento" method="post">
        <input class="btn btn-default mt-2" type="submit" value="Voltar">
    </form>
</body>