<?php
include('verifica_login.php');
?>

<?php

if(!isset($_GET['idAgenda'])){
    header('Location: index.php?menuop=agendamento');
    exit();
}

// Consulta a partir do idAgenda
$idAgenda = mysqli_real_escape_string($conexao, $_GET["idAgenda"]);
$sql = "SELECT idAgenda, nomeAgenda AS nomeAgenda, atividadeAgenda, cursoAgenda,
                bancadaTechAgenda, bancadaGeralAgenda, idUsuario, DATE_FORMAT(dataAgenda, '%d/%m/%Y') AS dataAgenda, 
                TIME_FORMAT(horaAgenda, '%H:%i') AS horaAgenda FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

if ($dados["idUsuario"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=agendamento');
    exit();
}
?>

<div class="container">
    <header class="text-center mt-5">
        <h4>Deseja excluir os dados abaixo?</h4>
    </header>

    <body>
        <div class="row mt-4">
            <div class="col-2"></div>
            <div class="col-8 shadow-sm rounded border">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="bi bi-person-fill"> Organizador</th>
                            <th scope="col">Atividade</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Bancadas Tech</th>
                            <th scope="col">Bancadas Gerais</th>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= $dados["nomeAgenda"] ?></td>
                        <td class="text-nowrap"><?= $dados["atividadeAgenda"] ?></td>
                        <td class="text-nowrap"><?= $dados["cursoAgenda"] ?></td>
                        <td><?= $dados["bancadaTechAgenda"] ?></td>
                        <td><?= $dados["bancadaGeralAgenda"] ?></td>
                        <td><?= $dados["dataAgenda"] ?></td>
                        <td><?= $dados["horaAgenda"] ?></td>
                    </tbody>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="mt-4 d-flex flex-row-reverse">
                    <!-- Excluir button -->
                    <div>
                        <form action="index.php?menuop=excluir-agendamento" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Excluir">
                            <input type="hidden" name="idAgenda" value="<?= $idAgenda ?>">
                        </form>
                    </div>
                    <!-- Voltar button -->
                    <div class="me-2">
                        <form action="index.php?menuop=agendamento" method="post">
                            <input class="btn btn-outline-ceub mt-2" type="submit" value="Voltar">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </body>
</div>