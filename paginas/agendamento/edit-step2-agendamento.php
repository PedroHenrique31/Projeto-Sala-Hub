<?php
include('verifica_login.php');
?>

<?php

if (!isset($_POST['nomeAgenda']) || !isset($_POST['atividadeAgenda']) || !isset($_POST['cursoAgenda']) || !isset($_POST['dataAgenda'])) {
    header('Location: index.php?menuop=agendamento');
    exit();
}
$nomeAgenda = $_POST['nomeAgenda'];
$atividadeAgenda = $_POST['atividadeAgenda'];
$cursoAgenda = $_POST['cursoAgenda'];
$dataAgenda = $_POST['dataAgenda'];
$horaAgenda = mysqli_real_escape_string($conexao, $_POST["horaAgenda"]);

// Adquire os dados baseado no idUsuario
$idAgenda = $_POST["idAgenda"];

$sql = "SELECT * FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);
if ($dados['idUsuario'] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=agendamento');
    exit();
}


// echo "DATA= | $dataAgenda | \n";
$dataAtual = date("Y-m-d");
// echo "HOJE= | $dataAtual | \n";

$date = date_create($dataAtual);

$dataAtualPlus1day = date_add($date, date_interval_create_from_date_string("1 days"));
$dataAtualPlus1day = $dataAtualPlus1day->format('Y-m-d');  // data atual + 1 dia
// echo "HOJE +1 = | $dataAtualPlus1day | \n";

$dataAtualPlus1Months = date_add($date, date_interval_create_from_date_string("1 months"));
$dataAtualPlus1Months = $dataAtualPlus1Months->format('Y-m-d');  // data atual + 1 meses

// Data atual para print
$dateAux = date_create($dataAgenda);
$dateAux = $dateAux->format('d/m/Y');

// Data atual + 1 dia para print
$dateAux2 = date_create($dataAtualPlus1day);
$dateAux2 = $dateAux2->format('d/m/Y');

// Data atual + 1 meses para print
$dateAux3 = date_create($dataAtualPlus1Months);
$dateAux3 = $dateAux3->format('d/m/Y');

?>

<div class="container">

    <?php
    if ($dataAgenda < $dataAtualPlus1day || $dataAgenda > $dataAtualPlus1Months) { ?>

        <body>
            <div class="mt-5 d-flex justify-content-center">
                <div class="rounded-4 p-4 border border-4 shadow-sm text-center">
                    <div class="fs-3">
                        Favor, escolher uma data entre <br><span class="fw-bold"><?= $dateAux2 ?></span> e <span class="fw-bold"><?= $dateAux3 ?></span>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=edit-step1-agendamento" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                            <input type="hidden" name="nomeAgenda" value="<?= $nomeAgenda ?>">
                            <input type="hidden" name="atividadeAgenda" value="<?= $atividadeAgenda ?>">
                            <input type="hidden" name="cursoAgenda" value="<?= $cursoAgenda ?>">
                            <input type="hidden" name="dataAgenda" value="<?= $dataAgenda ?>">
                        </form>
                    </div>
                </div>
            </div>
        </body>

    <?php exit();
    } ?>

    <header>
        <div class="mt-3 text-center">
            <img src="img/progress2.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <!-- div englobando tudo -->
        <div class="container mt-3">
            <!-- Formulário -->
            <form action="index.php?menuop=extra-edit-agendamento" method="post">
                <div class="row">
                    <!-- Horários -->
                    <div class="col-2">
                        <label class="form-label" for="horaAgenda">Horário</label>
                        <select class="form-control" name="horaAgenda" id="horaAgenda" required>
                            <option value="">Horário da reserva</option>
                            <?php if ($horaAgenda == '08:00:00') { ?><option selected value="08:00:00">08:00</option><?php } else { ?><option value="08:00:00">08:00</option><?php } ?>
                            <?php if ($horaAgenda == '09:00:00') { ?><option selected value="09:00:00">09:00</option><?php } else { ?><option value="09:00:00">09:00</option><?php } ?>
                            <?php if ($horaAgenda == '10:00:00') { ?><option selected value="10:00:00">10:00</option><?php } else { ?><option value="10:00" :00>10:00</option><?php } ?>
                            <?php if ($horaAgenda == '11:00:00') { ?><option selected value="11:00:00">11:00</option><?php } else { ?><option value="11:00:00">11:00</option><?php } ?>
                            <?php if ($horaAgenda == '12:00:00') { ?><option selected value="12:00:00">12:00</option><?php } else { ?><option value="12:00:00">12:00</option><?php } ?>
                            <?php if ($horaAgenda == '13:00:00') { ?><option selected value="13:00:00">13:00</option><?php } else { ?><option value="13:00:00">13:00</option><?php } ?>
                            <?php if ($horaAgenda == '14:00:00') { ?><option selected value="14:00:00">14:00</option><?php } else { ?><option value="14:00:00">14:00</option><?php } ?>
                            <?php if ($horaAgenda == '15:00:00') { ?><option selected value="15:00:00">15:00</option><?php } else { ?><option value="15:00:00">15:00</option><?php } ?>
                            <?php if ($horaAgenda == '16:00:00') { ?><option selected value="16:00:00">16:00</option><?php } else { ?><option value="16:00:00">16:00</option><?php } ?>
                            <?php if ($horaAgenda == '17:00:00') { ?><option selected value="17:00:00">17:00</option><?php } else { ?><option value="17:00:00">17:00</option><?php } ?>
                            <?php if ($horaAgenda == '18:00:00') { ?><option selected value="18:00:00">18:00</option><?php } else { ?><option value="18:00:00">18:00</option><?php } ?>
                            <?php if ($horaAgenda == '19:00:00') { ?><option selected value="19:00:00">19:00</option><?php } else { ?><option value="19:00:00">19:00</option><?php } ?>
                            <?php if ($horaAgenda == '20:00:00') { ?><option selected value="20:00:00">20:00</option><?php } else { ?><option value="20:00:00">20:00</option><?php } ?>
                            <?php if ($horaAgenda == '21:00:00') { ?><option selected value="21:00:00">21:00</option><?php } else { ?><option value="21:00:00">21:00</option><?php } ?>
                        </select>
                    </div>

                    <!-- Bancadas Tech -->
                    <div class="col-2">
                        <label class="form-label" for="bancadaTechAgenda">Bancadas Tech</label>
                        <select class="form-control" name="bancadaTechAgenda" id="bancadaTechAgenda" required>
                            <?php if ($dados['bancadaTechAgenda'] == 0) { ?><option selected value="0">0</option><?php } else { ?><option value="0">0</option><?php } ?>
                            <?php if ($dados['bancadaTechAgenda'] == 1) { ?><option selected value="1">1</option><?php } else { ?><option value="1">1</option><?php } ?>
                            <?php if ($dados['bancadaTechAgenda'] == 2) { ?><option selected value="2">2</option><?php } else { ?><option value="2">2</option><?php } ?>
                            <?php if ($dados['bancadaTechAgenda'] == 3) { ?><option selected value="3">3</option><?php } else { ?><option value="3">3</option><?php } ?>
                        </select>
                    </div>

                    <!-- Bancadas Gerais -->
                    <div class="col-2">
                        <label class="form-label" for="bancadaGeralAgenda">Bancadas Gerais</label>
                        <select class="form-control" name="bancadaGeralAgenda" id="bancadaGeralAgenda" required>
                            <?php if ($dados['bancadaGeralAgenda'] == 0) { ?><option selected value="0">0</option><?php } else { ?><option value="0">0</option><?php } ?>
                            <?php if ($dados['bancadaGeralAgenda'] == 1) { ?><option selected value="1">1</option><?php } else { ?><option value="1">1</option><?php } ?>
                            <?php if ($dados['bancadaGeralAgenda'] == 2) { ?><option selected value="2">2</option><?php } else { ?><option value="2">2</option><?php } ?>
                            <?php if ($dados['bancadaGeralAgenda'] == 3) { ?><option selected value="3">3</option><?php } else { ?><option value="3">3</option><?php } ?>
                        </select>
                    </div>

                    <!-- Hidden inputs -->
                    <input type="hidden" name="nomeAgenda" value="<?= $nomeAgenda ?>">
                    <input type="hidden" name="atividadeAgenda" value="<?= $atividadeAgenda ?>">
                    <input type="hidden" name="cursoAgenda" value="<?= $cursoAgenda ?>">
                    <input type="hidden" name="dataAgenda" value="<?= $dataAgenda ?>">
                    <input type="hidden" name="idAgenda" value="<?= $idAgenda ?>">

                </div>

                <div class="mt-4">
                    <?php $date = date_create($dataAgenda);
                    $dateAux = date_format($date, 'd/m'); ?>
                    <span class="fs-4">Bancadas disponíveis em <?= $dateAux?></span>
                </div>

                <!-- Lista de Tabelas   Manhã | Tarde | Noite -->
                <div class="row mt-3 border border-1 rounded shadow-sm">
                    <!-- Tabela 1 | Manhã -->
                    <div class="tabela1 col-4 mt-3">
                        <h3>Manhã</h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Tech</th>
                                    <th scope="col">Gerais</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <!-- Coluna 08:00-->
                                <tr>
                                    <td>08:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '08:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '08:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 09:00-->
                                <tr>
                                    <td>09:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '09:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '09:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>


                                <!-- Coluna 10:00-->
                                <tr>
                                    <td>10:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '10:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '10:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 11:00-->
                                <tr>
                                    <td>11:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '11:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '11:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabela 2 -->
                    <div class="tabela2 col-4 mt-3 mb-3">
                        <h3>Tarde</h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Tech</th>
                                    <th scope="col">Gerais</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <!-- Coluna 12:00-->
                                <tr>
                                    <td>12:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '12:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '12:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 13:00-->
                                <tr>
                                    <td>13:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '13:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '13:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 14:00-->
                                <tr>
                                    <td>14:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '14:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '14:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 15:00-->
                                <tr>
                                    <td>15:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '15:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '15:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 16:00-->
                                <tr>
                                    <td>16:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '16:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '16:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                                <!-- Coluna 17:00-->
                                <tr>
                                    <td>17:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '17:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '17:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Tabela 3 -->
                    <div class="tabela3 col-4 mt-3">
                        <h3>Noite</h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Tech</th>
                                    <th scope="col">Gerais</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <!-- Coluna 18:00-->
                                <tr>
                                    <td>18:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '18:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '18:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>


                                <!-- Coluna 19:00-->
                                <tr>
                                    <td>19:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '19:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '19:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>


                                <!-- Coluna 20:00-->
                                <tr>
                                    <td>20:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '20:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '20:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>


                                <!-- Coluna 21:00-->
                                <tr>
                                    <td>21:00</td>
                                    <!-- SELECT das bancadas TECH -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '21:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                    <!-- SELECT das bancadas Gerais -->
                                    <?php
                                    $result = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS value_sum FROM tbagenda WHERE idAgenda != '$idAgenda' AND dataAgenda = '$dataAgenda' AND horaAgenda = '21:00'");
                                    $row = mysqli_fetch_assoc($result);
                                    $sum = $row['value_sum'];
                                    $final = 3 - $sum;
                                    if ($final > 0) { ?>
                                        <td><?php echo "$final" ?></td>
                                    <?php } else { ?>
                                        <td>Esgotado</td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- DIV com os Botões -->
                <div class="mt-4 d-flex flex-row-reverse">
                    <!-- Submit button -->
                    <div class="">
                        <input class="btn btn-light" type="submit" value="Próximo">
            </form>
        </div>
        <!-- Back button -->
        <div class="me-2">
            <!-- Dados para voltar ao step1 -->
            <a class="btn btn-outline-ceub" role="button" href="index.php?menuop=edit-step1-agendamento&idAgenda=<?= $dados["idAgenda"] ?>">Voltar</a>
        </div>
</div>

</div>
</body>

</div>