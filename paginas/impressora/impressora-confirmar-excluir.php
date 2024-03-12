<?php
include('verifica_login.php');
?>

<?php

if (!isset($_GET['idImpressora'])) {
    header('Location: index.php?menuop=impressora');
    exit();
}

// Consulta a partir do idImpressora
$idImpressora = mysqli_real_escape_string($conexao, $_GET["idImpressora"]);
$sql = "SELECT idImpressora, nomeImpressora AS nomeImpressora, semestreImpressora, cursoImpressora,
                idUsuario, DATE_FORMAT(dataImpressora, '%d/%m/%Y') AS dataImpressora, qualImpressora,
                TIME_FORMAT(deHoraImpressora, '%H:%i') AS deHoraImpressora, TIME_FORMAT(ateHoraImpressora, '%H:%i') AS ateHoraImpressora 
                FROM tbimpressora WHERE idImpressora = '{$idImpressora}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

if ($dados["idUsuario"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=impressora');
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
                            <th scope="col">Curso</th>
                            <th scope="col">Semestre</th>
                            <th scope="col">Data</th>
                            <th scope="col">Horário</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= strip_tags($dados["nomeImpressora"]) ?></td>
                            <td class="text-nowrap" style="overflow:hidden; white-space: nowrap;"><?= strip_tags($dados["cursoImpressora"]) ?></td>
                            <td><?= $dados["semestreImpressora"] ?>º</td>
                            <td><?= $dados["dataImpressora"] ?></td>
                            <td><?= $dados["deHoraImpressora"] ?> - <?= $dados["ateHoraImpressora"] ?></td>
                            <td><?= $dados["qualImpressora"] ?></td>
                        </tr>
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
                        <form action="index.php?menuop=impressora-excluir" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Excluir">
                            <input type="hidden" name="idImpressora" value="<?= $idImpressora ?>">
                        </form>
                    </div>
                    <!-- Voltar button -->
                    <div class="me-2">
                        <form action="index.php?menuop=impressora" method="post">
                            <input class="btn btn-outline-ceub mt-2" type="submit" value="Voltar">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </body>
</div>