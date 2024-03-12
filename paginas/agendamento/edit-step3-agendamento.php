<?php
include('verifica_login.php');
?>

<?php
// Se n existir algum dado, retorna
if (
    !isset($_POST['nomeAgenda']) || !isset($_POST['atividadeAgenda']) || !isset($_POST['cursoAgenda']) || !isset($_POST['dataAgenda']) ||
    !isset($_POST['bancadaTechAgenda']) || !isset($_POST['bancadaGeralAgenda']) || !isset($_POST['horaAgenda'])
) {
    header('Location: index.php?menuop=agendamento');
    exit();
}

$nomeAgenda = mysqli_real_escape_string($conexao, $_POST["nomeAgenda"]);
if ($_SESSION['administrador'] != 1) {
    $nomeAgenda = $_SESSION['nome'];
}
$atividadeAgenda = mysqli_real_escape_string($conexao, $_POST["atividadeAgenda"]);
$cursoAgenda = mysqli_real_escape_string($conexao, $_POST["cursoAgenda"]);
$bancadaTechAgenda = mysqli_real_escape_string($conexao, $_POST["bancadaTechAgenda"]);
$bancadaGeralAgenda = mysqli_real_escape_string($conexao, $_POST["bancadaGeralAgenda"]);
$dataAgenda = mysqli_real_escape_string($conexao, $_POST["dataAgenda"]);
$horaAgenda = mysqli_real_escape_string($conexao, $_POST["horaAgenda"]);
$idAgenda = mysqli_real_escape_string($conexao, $_POST["idAgenda"]);

$cursosPermitidos = [
    'Administração', 'Análise e Desenvolvimento de Sistemas', 'Arquitetura e Urbanismo', 'Biomedicina', 'Ciência da Computação',
    'Ciência de dados e Machine Learning', 'Ciências Biológicas', 'Ciências Contábeis', 'Direito', 'Educação Física', 'Enfermagem',
    'Engenharia Civil', 'Engenharia de Computação', 'Engenharia Elétrica', 'Fisioterapia', 'Jornalismo', 'Marketing', 'Medicina',
    'Medicina Veterinária', 'Nutrição', 'Psicologia', 'Publicidade e Propaganda', 'Relações Internacionais'
];

$horasPermitidas = [
    '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00',
    '18:00:00', '19:00:00', '20:00:00', '21:00:00'
];

$dataAtual = date("Y-m-d");
$date = date_create($dataAtual);
$dataAtualPlus1day = date_add($date, date_interval_create_from_date_string("1 days"));
$dataAtualPlus1day = $dataAtualPlus1day->format('Y-m-d');  // data atual + 1 dia
$dataAtualPlus1Months = date_add($date, date_interval_create_from_date_string("1 months"));
$dataAtualPlus1Months = $dataAtualPlus1Months->format('Y-m-d');  // data atual + 1 meses

if ((!preg_match("/^[A-Za-zÀ-ú \']+$/", $nomeAgenda)) || (!preg_match("/^\S(.*\S)?$/", $atividadeAgenda)) || (!in_array($cursoAgenda, $cursosPermitidos)) ||
    (strlen($nomeAgenda) < 3) || (strlen($nomeAgenda) > 30) || (strlen($atividadeAgenda) < 5) || (strlen($atividadeAgenda) > 50) ||
    (!preg_match("/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $dataAgenda)) ||
    (!preg_match("/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/", $horaAgenda)) || (!preg_match("/\b[0123]\b$/", $bancadaTechAgenda)) ||
    (!preg_match("/\b[0123]\b$/", $bancadaGeralAgenda)) || (strlen($bancadaTechAgenda) > 1) || (strlen($bancadaGeralAgenda) > 1) ||
    $dataAgenda < $dataAtualPlus1day || $dataAgenda > $dataAtualPlus1Months || (!in_array($horaAgenda, $horasPermitidas))
) {
    echo ("<div class='mt-5 d-flex justify-content-center'>
        <div class='rounded-4 p-4 border border-4 shadow-sm'>
        <div class='text-center'>
        <h4>O formato das informações digitadas é inválido. Preencha novamente.</h4>
        </div>
        <div class='text-center'>
        <form action='index.php?menuop=edit-step1-agendamento&idAgenda=$idAgenda' method='post'>
        <input class='btn btn-light mt-2' type='submit' value='Voltar'>");
    exit();
}

// Consulta o idUsuário e perfil do usuário para checar se possui permissão de alterar o registro
$sqlSecurity = "SELECT * FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
$rs = mysqli_query($conexao, $sqlSecurity) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);
if ($dados['idUsuario'] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=agendamento');
    exit();
}

// Consulta SQL para checar disponibilidade de Bancadas Tech
$resultT = mysqli_query($conexao, "SELECT SUM(bancadaTechAgenda) AS somaT FROM tbagenda WHERE dataAgenda = '$dataAgenda' AND horaAgenda = '$horaAgenda' AND idAgenda != '$idAgenda'");
$rowT = mysqli_fetch_assoc($resultT);
$sumT = $rowT['somaT'];    // número de Bancadas Tech ocupadas
$availableT = 3 - $sumT;  // número de Bancadas Tech disponíveis

// Consulta SQL para checar disponibilidade de Bancadas Gerais
$resultG = mysqli_query($conexao, "SELECT SUM(bancadaGeralAgenda) AS somaG FROM tbagenda WHERE dataAgenda = '$dataAgenda' AND horaAgenda = '$horaAgenda' AND idAgenda != '$idAgenda'");
$rowG = mysqli_fetch_assoc($resultG);
$sumG = $rowG['somaG'];    // número de Bancadas Gerais ocupadas
$availableG = 3 - $sumG;  // número de Bancadas Gerais disponíveis



// CONSULTA PARA PEGAR MONITORES VÁLIDOS NAQUELE HORARIO
$sqlMonitores = "SELECT * FROM tbmonitor WHERE deHoraMonitor <= '$horaAgenda' AND ateHoraMonitor > '$horaAgenda'";
$rsMonitores = mysqli_query($conexao, $sqlMonitores) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
if (mysqli_num_rows($rsMonitores) == 0) {
    $disponibilidadeMonitor = 0;
} else {
    $disponibilidadeMonitor = 1;
}


if ($disponibilidadeMonitor) {
    $idMonitorDisponivel = 0;

    while ($dadosMonitores = mysqli_fetch_assoc($rsMonitores)) {
        $id = $dadosMonitores['idMonitor'];
        $result = $conexao->query("SELECT idMonitor FROM tbagenda WHERE dataAgenda = '$dataAgenda' AND horaAgenda = '$horaAgenda' AND idMonitor = $id");
        if ($result->num_rows == 0) {
            $idMonitorDisponivel = $id;
        }
    }

    if ($idMonitorDisponivel == 0) {
        // Método SQL para ver qual monitor está com mais disponibilidade no horário da reserva
        $sqlMonitor = "SELECT
        idMonitor,
        COUNT(idMonitor) AS `value_occurrence` 
    
        FROM
        tbagenda

        WHERE
        idMonitor != 0
    
        GROUP BY 
        idMonitor
    
        ORDER BY 
        `value_occurrence` ASC
    
        LIMIT 1;";

        $rsMonitor = mysqli_query($conexao, $sqlMonitor) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
        $dadosMonitor = mysqli_fetch_assoc($rsMonitor);

        // $rss = $conexao->query("SELECT * FROM tbmonitor WHERE deHoraMonitor <= '$horaAgenda' AND ateHoraMonitor > '$horaAgenda' AND $idMonitorDisponivel = idMonitor");
        $idMonitorDisponivel = $dadosMonitor['idMonitor'];
    }
}



if (!$disponibilidadeMonitor) {
    $idMonitorDisponivel = 0;
}


// Função de formatação de telefone
function format_string($mask, $str, $ch = '#')
{
    $c = 0;
    $rs = '';
    /*
    Aqui usamos strlen() pois não há preocupação com o charset da máscara.
    */
    for ($i = 0; $i < strlen($mask); $i++) {
        if ($mask[$i] == $ch) {
            $rs .= $str[$c];
            $c++;
        } else {
            $rs .= $mask[$i];
        }
    }
    return $rs;
}


?>

<div class="container">
    <header>
        <div class="mt-3 text-center">
            <img src="img/progress3.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <!-- main div -->
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">
                <?php
                // Se o valor não foi selecionado para nenhuma das bancadas, voltar para STEP 2
                if ($bancadaTechAgenda == 0 && $bancadaGeralAgenda == 0) { ?>
                    <div class="text-center">
                        <h4>Por favor, escolha um número de bancadas.</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=edit-step2-agendamento" method="post">
                            <input type="hidden" name="nomeAgenda" value="<?= $nomeAgenda ?>">
                            <input type="hidden" name="atividadeAgenda" value="<?= $atividadeAgenda ?>">
                            <input type="hidden" name="cursoAgenda" value="<?= $cursoAgenda ?>">
                            <input type="hidden" name="dataAgenda" value="<?= $dataAgenda ?>">
                            <input type="hidden" name="horaAgenda" value="<?= $horaAgenda ?>">
                            <input type="hidden" name="idAgenda" value="<?= $idAgenda ?>">
                            <input class="btn btn-light mt-2" type="submit" value="Escolher bancadas">
                        </form>
                    </div>
                <?php
                }
                // Se houver Bancadas suficientes, insere os dados na tabela
                else if (($availableT - $bancadaTechAgenda) >= 0 && ($availableG - $bancadaGeralAgenda) >= 0) {
                    $sql = "UPDATE tbagenda SET 
                nomeAgenda = '{$nomeAgenda}',
                atividadeAgenda = '{$atividadeAgenda}',
                cursoAgenda = '{$cursoAgenda}',
                bancadaTechAgenda = '{$bancadaTechAgenda}',
                bancadaGeralAgenda = '{$bancadaGeralAgenda}',
                dataAgenda = '{$dataAgenda}',
                horaAgenda = '{$horaAgenda}',
                idMonitor = '{$idMonitorDisponivel}'
                WHERE idAgenda = '{$idAgenda}'
                ";
                    mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro

                ?>



                    <?php if ($disponibilidadeMonitor) {
                        // Consulta para printar o monitor
                        $sqlMM = "SELECT * FROM tbmonitor WHERE idMonitor = {$idMonitorDisponivel}";
                        $rsMM = mysqli_query($conexao, $sqlMM) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
                        $dadosMM = mysqli_fetch_assoc($rsMM);
                        $nomeMonitor = $dadosMM['nomeMonitor'];
                        $telefoneMonitor = $dadosMM['telefoneMonitor'];
                        $n = $telefoneMonitor; // número que o usuário digitou
                        $str = $n; // Exemplo para telefone
                    ?>

                        <div class="text-center">
                            <h4>Atualização feita com sucesso!</h4>
                            <div class="d-flex flex-row mt-3 align-middle">
                                <h5 class="align-middle">Monitor:&nbsp</h5>
                                <h5 style="font-weight: normal;"><?= $nomeMonitor ?></h5>
                            </div>
                            <div class="d-flex flex-row">
                                <h5>Telefone:&nbsp</h5>
                                <h5 style="font-weight: normal;"><?php echo format_string('(##) #####-####', $str); ?></h5>
                            </div>

                        </div>
                    <?php } else { ?>
                        <div class="text-center">
                            <h4>Atualização feita com sucesso!</h4>
                        </div>

                    <?php } ?>
                    <div class="text-center">
                        <form action="index.php?menuop=agendamento" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                        </form>
                    </div>


                <?php
                    // Se não houver Bancadas suficientes, manda de volta para o 'Step 2' juntamente com os dados inseridos
                } else {
                ?>
                    <div class="text-center">
                        <h4>Sem Bancadas suficientes.</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=edit-step2-agendamento" method="post">
                            <input type="hidden" name="nomeAgenda" value="<?= $nomeAgenda ?>">
                            <input type="hidden" name="atividadeAgenda" value="<?= $atividadeAgenda ?>">
                            <input type="hidden" name="cursoAgenda" value="<?= $cursoAgenda ?>">
                            <input type="hidden" name="dataAgenda" value="<?= $dataAgenda ?>">
                            <input type="hidden" name="horaAgenda" value="<?= $horaAgenda ?>">
                            <input type="hidden" name="idAgenda" value="<?= $idAgenda ?>">
                            <input class="btn btn-light mt-2" type="submit" value="Escolher outro horário">
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>

    </body>

</div>