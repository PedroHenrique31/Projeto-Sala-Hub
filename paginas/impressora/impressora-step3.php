<?php
include('verifica_login.php');
?>

<?php
// Se n existir algum dado, retorna
if (
    !isset($_POST['nomeImpressora']) || !isset($_POST['cursoImpressora']) || !isset($_POST['semestreImpressora']) || 
    !isset($_POST['dataImpressora']) || !isset($_POST['deHoraImpressora']) || !isset($_POST['ateHoraImpressora'])
) {
    header('Location: index.php?menuop=impressora');
    exit();
}

$nomeImpressora = mysqli_real_escape_string($conexao, $_POST["nomeImpressora"]);
if ($_SESSION['administrador'] != 1) {
    $nomeImpressora = $_SESSION['nome'];
}
$cursoImpressora = mysqli_real_escape_string($conexao, $_POST["cursoImpressora"]);
$semestreImpressora = mysqli_real_escape_string($conexao, $_POST["semestreImpressora"]);
$deHoraImpressora = mysqli_real_escape_string($conexao, $_POST["deHoraImpressora"]);
$ateHoraImpressora = mysqli_real_escape_string($conexao, $_POST["ateHoraImpressora"]);
$dataImpressora = mysqli_real_escape_string($conexao, $_POST["dataImpressora"]);
$idUsuario = $_SESSION['usuario_id'];

$cursosPermitidos = [
    'Administração', 'Análise e Desenvolvimento de Sistemas', 'Arquitetura e Urbanismo', 'Biomedicina', 'Ciência da Computação',
    'Ciência de dados e Machine Learning', 'Ciências Biológicas', 'Ciências Contábeis', 'Direito', 'Educação Física', 'Enfermagem',
    'Engenharia Civil', 'Engenharia de Computação', 'Engenharia Elétrica', 'Fisioterapia', 'Jornalismo', 'Marketing', 'Medicina',
    'Medicina Veterinária', 'Nutrição', 'Psicologia', 'Publicidade e Propaganda', 'Relações Internacionais'
];

$deHorasPermitidas = [
    '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00',
    '18:00:00', '19:00:00', '20:00:00'
];

$ateHorasPermitidas = [
    '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00',
    '18:00:00', '19:00:00', '20:00:00', '21:00:00'
];

$dataAtual = date("Y-m-d");
$date = date_create($dataAtual);
$dataAtualPlus1day = date_add($date, date_interval_create_from_date_string("1 days"));
$dataAtualPlus1day = $dataAtualPlus1day->format('Y-m-d');  // data atual + 1 dia
$dataAtualPlus1Months = date_add($date, date_interval_create_from_date_string("1 months"));
$dataAtualPlus1Months = $dataAtualPlus1Months->format('Y-m-d');  // data atual + 1 meses

if ((!preg_match("/^[A-Za-zÀ-ú \']+$/", $nomeImpressora)) || (!in_array($cursoImpressora, $cursosPermitidos)) || (strlen($nomeImpressora) < 3) ||
    (strlen($nomeImpressora) > 30) ||  (!preg_match("/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $dataImpressora)) ||
    (!in_array($deHoraImpressora, $deHorasPermitidas)) || (!in_array($ateHoraImpressora, $ateHorasPermitidas)) ||
    $dataImpressora < $dataAtualPlus1day || $dataImpressora > $dataAtualPlus1Months
) {
    echo ("<div class='mt-5 d-flex justify-content-center'>
        <div class='rounded-4 p-4 border border-4 shadow-sm'>
        <div class='text-center'>
        <h4>O formato das informações digitadas é inválido. Preencha novamente.</h4>
        </div>
        <div class='text-center'>
        <form action='index.php?menuop=impressora-step1' method='post'>
        <input class='btn btn-light mt-2' type='submit' value='Voltar'>
        <input type='hidden' name='cursoImpressora' value='$cursoImpressora'>
        <input type='hidden' name='semestreImpressora' value='$semestreImpressora'>
        <input type='hidden' name='dataImpressora' value='$dataImpressora'>");
    exit();
}

// SQL para checar disponibilidade da impressora
$sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora 
        FROM tbimpressora  WHERE dataImpressora = '$dataImpressora'";

// Variável para executar a consulta
$rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

$available1 = 1;
$available2 = 1;

// Loop para mostrar os dados
while ($dados = mysqli_fetch_assoc($rs)) {
    if ($dados['qualImpressora'] == 1) {
        if($deHoraImpressora > $dados['deHoraImpressora']){
            if($deHoraImpressora < $dados['ateHoraImpressora']){
                $available1 = 0;
            }
        }
        if($ateHoraImpressora < $dados['ateHoraImpressora']){
            if($ateHoraImpressora > $dados['deHoraImpressora']){
                $available1 = 0;
            }
        }
        if(($deHoraImpressora < $dados['deHoraImpressora']) && ($ateHoraImpressora > $dados['ateHoraImpressora'])){
            $available1 = 0;
        }
        if($deHoraImpressora == $dados['deHoraImpressora'] || 
        $deHoraImpressora == $dados['ateHoraImpressora'] || 
        $ateHoraImpressora == $dados['deHoraImpressora'] || 
        $ateHoraImpressora == $dados['ateHoraImpressora']){
            $available1 = 0;
        }
    }
    if ($dados['qualImpressora'] == 2) {
        if($deHoraImpressora > $dados['deHoraImpressora']){
            if($deHoraImpressora < $dados['ateHoraImpressora']){
                $available2 = 0;
            }
        }
        if($ateHoraImpressora < $dados['ateHoraImpressora']){
            if($ateHoraImpressora > $dados['deHoraImpressora']){
                $available2 = 0;
            }
        }
        if(($deHoraImpressora < $dados['deHoraImpressora']) && ($ateHoraImpressora > $dados['ateHoraImpressora'])){
            $available2 = 0;
        }
        if($deHoraImpressora == $dados['deHoraImpressora'] || 
        $deHoraImpressora == $dados['ateHoraImpressora'] || 
        $ateHoraImpressora == $dados['deHoraImpressora'] || 
        $ateHoraImpressora == $dados['ateHoraImpressora']){
            $available2 = 0;
        }
    };
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
                // Se o horário não foi preenchido
                if ($deHoraImpressora == 0 || $ateHoraImpressora == 0  || $deHoraImpressora >= $ateHoraImpressora) { ?>
                    <div class="text-center">
                        <h4 class="fs-4">Por favor, escolher um horário válido.</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=impressora-step2" method="post">
                            <input type="hidden" name="nomeImpressora" value="<?= $nomeImpressora ?>">
                            <input type="hidden" name="semestreImpressora" value="<?= $semestreImpressora ?>">
                            <input type="hidden" name="cursoImpressora" value="<?= $cursoImpressora ?>">
                            <input type="hidden" name="dataImpressora" value="<?= $dataImpressora ?>">
                            <input type="hidden" name="deHoraImpressora" value="<?= $deHoraImpressora ?>">
                            <input type="hidden" name="ateHoraImpressora" value="<?= $ateHoraImpressora ?>">
                            <input class="btn btn-light mt-2" type="submit" value="Escolher horários">
                        </form>
                    </div>
                <?php
                exit(); } ;
                ?>

                <?php
                // Se houver disponibilidade de impressora

                if ($available1) {
                    $sql = "INSERT INTO tbimpressora (
                        nomeImpressora,
                        cursoImpressora,
                        semestreImpressora,
                        dataImpressora,
                        deHoraImpressora,
                        ateHoraImpressora,
                        qualImpressora,
                        idUsuario)
                        VALUES(
                        '{$nomeImpressora}',
                        '{$cursoImpressora}',
                        '{$semestreImpressora}',
                        '{$dataImpressora}',
                        '{$deHoraImpressora}',
                        '{$ateHoraImpressora}',
                        1,
                        '{$idUsuario}'
                        )";
                    mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro
                ?>
                    <div class="text-center">
                        <h4>Reserva feita com sucesso!</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=impressora" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                        </form>
                    </div>
                <?php exit(); } else if ($available2) {
                    $sql = "INSERT INTO tbimpressora (
                        nomeImpressora,
                        cursoImpressora,
                        semestreImpressora,
                        dataImpressora,
                        deHoraImpressora,
                        ateHoraImpressora,
                        qualImpressora,
                        idUsuario)
                        VALUES(
                        '{$nomeImpressora}',
                        '{$cursoImpressora}',
                        '{$semestreImpressora}',
                        '{$dataImpressora}',
                        '{$deHoraImpressora}',
                        '{$ateHoraImpressora}',
                        2,
                        '{$idUsuario}'
                        )";
                    mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro
                ?>
                    <div class="text-center">
                        <h4>Reserva feita com sucesso!</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=impressora" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                        </form>
                    </div>

                <?php exit(); } else {
                    // Caso não tenha disponibilidade
                ?>
                    <div class="text-center">
                        <h4 class="fs-4">Sem disponibilidade entre <br><?php echo substr($deHoraImpressora, 0, -3) ?> e <?php echo substr($ateHoraImpressora, 0, -3) ?>.</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=impressora-step2" method="post">
                            <input type="hidden" name="nomeImpressora" value="<?= $nomeImpressora ?>">
                            <input type="hidden" name="semestreImpressora" value="<?= $semestreImpressora ?>">
                            <input type="hidden" name="cursoImpressora" value="<?= $cursoImpressora ?>">
                            <input type="hidden" name="dataImpressora" value="<?= $dataImpressora ?>">
                            <input type="hidden" name="deHoraImpressora" value="<?= $deHoraImpressora ?>">
                            <input type="hidden" name="ateHoraImpressora" value="<?= $ateHoraImpressora ?>">
                            <input class="btn btn-light mt-2" type="submit" value="Escolher outro horário">
                        </form>
                    </div>
                <?php exit(); } ?>
            </div>
        </div>
    </body>
</div>