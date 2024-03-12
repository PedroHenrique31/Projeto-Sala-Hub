<?php
include('verifica_login.php');
?>

<?php

if (!isset($_GET['idMonitor']) || $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=monitores');
    exit();
}

// Consulta a partir do idMonitor
$idMonitor = mysqli_real_escape_string($conexao, $_GET["idMonitor"]);
$sql = "SELECT idMonitor, nomeMonitor, telefoneMonitor, deHoraMonitor, ateHoraMonitor FROM tbmonitor WHERE idMonitor = '{$idMonitor}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);


// Função de formatação para apresentação do telefone
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
// Formatação do telefone
$n = $dados['telefoneMonitor']; // número que o usuário digitou
$str = $n; // Exemplo para telefone

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
                            <th><i class="bi bi-person-fill"> </i>Nome</th>
                            <th>Telefone</th>
                            <th>Horário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= strip_tags($dados["nomeMonitor"]) ?></td>
                        <td><?php echo format_string('(##)#####-####', $str); ?></td>
                        <td><?php echo substr($dados["deHoraMonitor"], 0, -3); ?> - <?php echo substr($dados["ateHoraMonitor"], 0, -3); ?></td>
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
                        <form action="index.php?menuop=excluir-monitores" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Excluir">
                            <input type="hidden" name="idMonitor" value="<?= $idMonitor ?>">
                        </form>
                    </div>
                    <!-- Voltar button -->
                    <div class="me-2">
                        <form action="index.php?menuop=monitores" method="post">
                            <input class="btn btn-outline-ceub mt-2" type="submit" value="Voltar">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </body>
</div>