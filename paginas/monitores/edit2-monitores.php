<?php
include('verifica_login.php');
?>

<?php
// Se n existir algum dado, retorna
if (
    !isset($_POST['nomeMonitor']) || !isset($_POST['telefoneMonitor']) || !isset($_POST['deHoraMonitor']) ||
    !isset($_POST['ateHoraMonitor']) || $_SESSION['administrador'] != 1
) {
    header('Location: index.php?menuop=monitores');
    exit();
}

$nomeMonitor = mysqli_real_escape_string($conexao, $_POST["nomeMonitor"]);
$telefoneMonitor = mysqli_real_escape_string($conexao, $_POST["telefoneMonitor"]);
$deHoraMonitor = mysqli_real_escape_string($conexao, $_POST["deHoraMonitor"]);
$ateHoraMonitor = mysqli_real_escape_string($conexao, $_POST["ateHoraMonitor"]);
$idMonitor = mysqli_real_escape_string($conexao, $_POST["idMonitor"]);

$deHorasPermitidas = [
    '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00',
    '18:00:00', '19:00:00', '20:00:00'
];

$ateHorasPermitidas = [
    '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00',
    '18:00:00', '19:00:00', '20:00:00', '21:00:00'
];

// Função para validar numero de celular/telefone
function celular($telefone)
{
    $telefone = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

    //$regexTelefone = "^[0-9]{11}$"; // Regex para validar telefone

    $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
    if (preg_match($regexCel, $telefone)) {
        return true;
    } else {
        return false;
    }
}

if ((!preg_match("/^[A-Za-zÀ-ú \']+$/", $nomeMonitor)) || (strlen($nomeMonitor) < 3) || (strlen($nomeMonitor) > 30) ||
    (!in_array($deHoraMonitor, $deHorasPermitidas)) || (!in_array($ateHoraMonitor, $ateHorasPermitidas))

) {
    echo ("<div class='mt-5 d-flex justify-content-center'>
        <div class='rounded-4 p-4 border border-4 shadow-sm'>
        <div class='text-center'>
        <h4>O formato das informações digitadas é inválido. Preencha novamente.</h4>
        </div>
        <div class='text-center'>
        <form action='index.php?menuop=step1-monitores' method='post'>
        <input class='btn btn-light mt-2' type='submit' value='Voltar'>
        <input type='hidden' name='nomeMonitor' value='$nomeMonitor'>
        <input type='hidden' name='telefoneMonitor' value='$telefoneMonitor'>
        <input type='hidden' name='deHoraMonitor' value='$deHoraMonitor'>
        <input type='hidden' name='ateHoraMonitor' value='$ateHoraMonitor'>");
    exit();
}

// VALIDANDO O TELEFONE


// número que o usuário digitou
$n = $telefoneMonitor;
$telefoneSoNumero = preg_replace("/[^0-9]/","", $n);
// echo $telefoneSoNumero; // ###########

if(strlen($telefoneSoNumero) != 11){
    echo ("<div class='mt-5 d-flex justify-content-center'>
        <div class='rounded-4 p-4 border border-4 shadow-sm'>
        <div class='text-center'>
        <h4>Telefone inválido. Preencha novamente.</h4>
        </div>
        <div class='text-center'>
        <form action='index.php?menuop=step1-monitores' method='post'>
        <input class='btn btn-light mt-2' type='submit' value='Voltar'>
        <input type='hidden' name='nomeMonitor' value='$nomeMonitor'>
        <input type='hidden' name='telefoneMonitor' value='$telefoneMonitor'>
        <input type='hidden' name='deHoraMonitor' value='$deHoraMonitor'>
        <input type='hidden' name='ateHoraMonitor' value='$ateHoraMonitor'>");
    exit();
}

function format_string($mask, $str, $ch = '#') {
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


$str = $telefoneSoNumero; // Exemplo para telefone
// echo format_string('(##)#####-####', $str);
?>

<div class="container">
<header class="text-center mt-3 mb-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Edição de Monitores</span>
        </div>
    </header>

    <body>
        <!-- main div -->
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">
                <?php
                // Se o horário não foi preenchido
                if ($deHoraMonitor == 0 || $ateHoraMonitor == 0  || $deHoraMonitor >= $ateHoraMonitor) { ?>
                    <div class="text-center">
                        <h4 class="fs-4">Por favor, escolher um horário válido.</h4>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=edit1-monitores&idMonitor=<?=$idMonitor?>" method="post">
                            <input type="hidden" name="nomeMonitor" value="<?= $nomeMonitor ?>">
                            <input type="hidden" name="telefoneMonitor" value="<?= $telefoneMonitor ?>">
                            <input type="hidden" name="deHoraMonitor" value="<?= $deHoraMonitor ?>">
                            <input type="hidden" name="ateHoraMonitor" value="<?= $ateHoraMonitor ?>">
                            <input class="btn btn-light mt-2" type="submit" value="Escolher horários">
                        </form>
                    </div>
                <?php
                    exit();
                };
                ?>

                <?php
                // Se tudo estiver correto, prosseguir com a inserção
                $sql = "UPDATE tbmonitor SET 
                        nomeMonitor = '{$nomeMonitor}',
                        telefoneMonitor = '{$telefoneSoNumero}',
                        deHoraMonitor = '{$deHoraMonitor}',
                        ateHoraMonitor = '{$ateHoraMonitor}'
                        WHERE idMonitor = '{$idMonitor}'
                        ";
                mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro
                ?>
                <div class="text-center">
                    <h4>Atualização feita com sucesso!</h4>
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