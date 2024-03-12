<?php
include('verifica_login.php');
?>

<div class="container">
    <header class="text-center mt-3 mb-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Agendamento</span>
        </div>
    </header>

    <!-- Barra de pesquisa --->
    <div class="d-flex justify-content-between">
        <form action="index.php?menuop=agendamento" method="post">
            <div class="input-group">
                <div>
                    <input class="form-control" type="text" name="txt_pesquisa" placeholder="Pesquisar...">
                </div>
                <button class="btn btn-outline-ceub btn-sm" type="submit"><i class="bi bi-search"></i> Pesquisar...</button>
            </div>
        </form>
        <!-- Botões -->
        <div class="d-flex flex-row">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#verMonitores">
                Ver monitores
            </button>
            <a href="index.php?menuop=impressora" class="btn btn-light me-2" role="button">Impressora 3D</a>
            <form action="index.php?menuop=step1-agendamento" method="post">
                <input class="btn btn-light" type="submit" value="Nova Reserva">
                <input type="hidden" name="nomeAgenda" value="">
                <input type="hidden" name="atividadeAgenda" value="">
                <input type="hidden" name="cursoAgenda" value="">
                <input type="hidden" name="dataAgenda" value="">
            </form>
        </div>
    </div>

    <?php
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



    <!-- Modal -->
    <div class="modal fade" id="verMonitores" tabindex="-1" aria-labelledby="verMonitoresLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="verMonitoresLabel">Lista de Monitores</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    // Método SQL para mostrar os monitores
                    $sql = "SELECT idMonitor, nomeMonitor, telefoneMonitor, deHoraMonitor, ateHoraMonitor FROM tbmonitor ORDER BY deHoraMonitor ASC";
                    // Variável para executar a consulta
                    $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                    // Loop para mostrar os cards
                    while ($dados = mysqli_fetch_assoc($rs)) {
                        $idMonitor = $dados['idMonitor']; 
                        $n = $dados['telefoneMonitor']; // número que o usuário digitou
                        $str = $n; // Exemplo para telefone

                        
                        ?>


                        <div class="d-flex flex-column mb-5 fs-6">
                            <div class="d-flex flex-row ">
                            <span class="text-nowrap bi bi-person-fill"  style="color:#78126b">&nbsp<?=$dados['nomeMonitor']?></span>
                            </div>
                            <div class="d-flex flex-row ">
                            <span class="fw-bold">Telefone:&nbsp</span><?php echo format_string('(##) #####-####', $str); ?>
                            </div>
                            <div class="d-flex flex-row ">
                            <span class="fw-bold">Horário:&nbsp</span><?php echo substr($dados["deHoraMonitor"], 0, -3); ?> - <?php echo substr($dados["ateHoraMonitor"], 0, -3); ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>






    <!-- Tópicos da tabela --->
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered shadow-sm">
            <thead>
                <tr>
                    <th><i class="bi bi-person-fill"> </i>Organizador</th>
                    <th>Atividade</th>
                    <th>Curso</th>
                    <th class="text-nowrap">Bancadas Tech</th>
                    <th class="text-nowrap">Bancadas Gerais</th>
                    <th>Hora</th>
                    <th>Data</th>
                    <th>Monitor</th>
                    <th class="text-center">Editar</th>
                    <th class="text-center">Excluir</th>

                </tr>
            </thead>

            <tbody>
                <?php

                // Quantidade de items por página
                $quantidade = 10;
                // Variável qual página ir
                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                // Variável para guardar o inicio da listagem
                $inicio = ($quantidade * $pagina) - $quantidade;

                // Variável de pesquisa para pesquisar na tabela
                $txt_pesquisa = (isset($_POST["txt_pesquisa"])) ? $_POST["txt_pesquisa"] : "";

                // Método SQL para mostrar a tabela
                $sql = "SELECT idAgenda, nomeAgenda AS nomeAgenda, atividadeAgenda, cursoAgenda, idMonitor, 
                bancadaTechAgenda, bancadaGeralAgenda, idUsuario, DATE_FORMAT(dataAgenda, '%d/%m/%Y') AS dataAgenda, TIME_FORMAT(horaAgenda, '%H:%i') AS horaAgenda FROM tbagenda
                WHERE dataAgenda >= CURDATE() and (idAgenda = '{$txt_pesquisa}' or nomeAgenda LIKE '%{$txt_pesquisa}%' or atividadeAgenda LIKE '%{$txt_pesquisa}%' 
                or cursoAgenda LIKE '%{$txt_pesquisa}%') ORDER BY DATE_FORMAT(dataAgenda, '%Y,%m,%d') ASC, horaAgenda ASC
                LIMIT {$inicio}, {$quantidade}";

                // Variável para executar a consulta
                $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                // Loop para mostrar os dados
                while ($dados = mysqli_fetch_assoc($rs)) {
                    $id = $dados['idAgenda'];
                    $idMonitor = $dados['idMonitor'];

                    // PRINTAR NOME MONITOR
                    $result = $conexao->query("SELECT nomeMonitor, idMonitor FROM tbmonitor WHERE idMonitor = {$idMonitor}");
                    if ($result->num_rows == 0
                    ) {
                        $nomeMonitor = '';
                    } else {
                        $dadosMM = mysqli_fetch_assoc($result);
                        $nomeMonitor = $dadosMM['nomeMonitor'];
                    }

                ?>
                    <!-- Se alguma célula tiver com dados muito grande, adicionar no td -> style="overflow:hidden; white-space: nowrap;"
                                                                        e adicionar na div table -> style="table-layout: fixed;"  -->
                    <tr>
                        <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= strip_tags($dados["nomeAgenda"]) ?></td>
                        <td class="text-nowrap" style="overflow:hidden; white-space: nowrap;"><?= strip_tags($dados["atividadeAgenda"]) ?></td>
                        <td class="text-nowrap" style="overflow:hidden; white-space: nowrap;"><?= strip_tags($dados["cursoAgenda"]) ?></td>
                        <td><?= $dados["bancadaTechAgenda"] ?></td>
                        <td><?= $dados["bancadaGeralAgenda"] ?></td>
                        <td><?= $dados["horaAgenda"] ?></td>
                        <td><?= $dados["dataAgenda"] ?></td>
                        <td><?= $nomeMonitor ?></td>
                        <td class="text-center"><a href="index.php?menuop=edit-step1-agendamento&idAgenda=<?= $dados["idAgenda"] ?>"><?php if ($dados['idUsuario'] == $_SESSION['usuario_id'] || $_SESSION['administrador'] == 1) {
                                                                                                                                            echo '<i class="bi bi-pencil-square" style="color:#78126b ;"></i>';
                                                                                                                                        } ?></a></td>
                        <td class="text-center"><a href="index.php?menuop=confirmar-excluir-agendamento&idAgenda=<?= $dados["idAgenda"] ?>"><?php if ($dados['idUsuario'] == $_SESSION['usuario_id'] || $_SESSION['administrador'] == 1) {
                                                                                                                                                echo '<i class="bi bi-trash3" style="color:#78126b ;"></i>';
                                                                                                                                            } ?></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <ul class="pagination justify-content-center">

        <?php
        $sqlTotal = "SELECT idAgenda FROM tbagenda";
        // Query results
        $qrTotal = mysqli_query($conexao, $sqlTotal) or die("Erro na query results. " . mysqli_error($conexao));
        $numTotal = mysqli_num_rows($qrTotal);
        $totalPaginas = ceil($numTotal / $quantidade);

        // Mostra o número de registros ao lado da paginação
        // echo "<li class='page-item'><span class='page-link'>Total de Registros: ". $numTotal . "</span></li>";

        // Primeira página
        echo '<li class="page-item"><a class="page-link" href="?menuop=agendamento&pagina=1"><i class="bx bx-chevrons-left" ></i></a></li>';

        // Método de paginação
        if ($pagina > 6) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=agendamento&pagina=<?php echo $pagina - 1 ?>" aria-label="Anterior"> <i class='bx bx-chevron-left'></i> </a></li>
        <?php
        }

        // Loop para numeração das páginas
        for ($i = 1; $i <= $totalPaginas; $i++) {

            if ($i >= ($pagina - 5) && $i <= ($pagina + 5)) {
                if ($i == $pagina) {
                    echo "<li class='page-item active page-item.active'><span class='page-link'>$i</span></li>";
                } else {
                    echo "<li class='page-item'> <a class='page-link' href=\"?menuop=agendamento&pagina=$i \">$i</a></li> ";
                }
            }
        }

        // Método de paginação
        if ($pagina < ($totalPaginas - 5)) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=agendamento&pagina=<?php echo $pagina + 1 ?>" aria-label="Proximo"> <i class='bx bx-chevron-right'></i> </a></li>
        <?php
        }

        // Última página
        echo "<li class='page-item'><a class='page-link' href=\"?menuop=agendamento&pagina=$totalPaginas\"><i class='bx bx-chevrons-right' ></i></a></li>";

        ?>
    </ul>

</div>