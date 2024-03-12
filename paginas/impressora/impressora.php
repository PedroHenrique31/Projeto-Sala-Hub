<?php
include('verifica_login.php');
?>

<?php 



?>

<div class="container">
<header class="text-center mt-3 mb-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Impressora 3D</span>
        </div>
    </header>

    <!-- Barra de pesquisa --->
    <div class="d-flex justify-content-between">
        <form action="index.php?menuop=impressora" method="post">
            <div class="input-group">
                <div>
                    <input class="form-control" type="text" name="txt_pesquisa" placeholder="Pesquisar...">
                </div>
                <button class="btn btn-outline-ceub btn-sm" type="submit"><i class="bi bi-search"></i> Pesquisar...</button>
            </div>
        </form>
        <!-- Botão para reserva em STEPS-->
        <form action="index.php?menuop=impressora-step1" method="post">
            <input class="btn btn-light" type="submit" value="Nova Reserva">
            <input type="hidden" name="cursoImpressora" value="">
            <input type="hidden" name="semestreImpressora" value="">
            <input type="hidden" name="dataImpressora" value="">
        </form>

    </div>


    <!-- Tópicos da tabela --->
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered shadow-sm">
            <thead>
                <tr>
                    <th><i class="bi bi-person-fill"> </i>Nome</th>
                    <th>Curso</th>
                    <th>Semestre</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>#</th>
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
                $sql = "SELECT idImpressora, nomeImpressora, semestreImpressora, cursoImpressora, idUsuario, 
                DATE_FORMAT(dataImpressora, '%d/%m/%Y') AS dataImpressora, TIME_FORMAT(deHoraImpressora, '%H:%i') AS deHoraImpressora,
                TIME_FORMAT(ateHoraImpressora, '%H:%i') AS ateHoraImpressora, qualImpressora FROM tbimpressora
                WHERE dataImpressora >= CURDATE() and (idImpressora = '{$txt_pesquisa}' or nomeImpressora LIKE '%{$txt_pesquisa}%' 
                or semestreImpressora LIKE '%{$txt_pesquisa}%' or cursoImpressora LIKE '%{$txt_pesquisa}%') 
                ORDER BY DATE_FORMAT(dataImpressora, '%Y,%m,%d') ASC, deHoraImpressora ASC LIMIT {$inicio}, {$quantidade}";

                // Variável para executar a consulta
                $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                // Loop para mostrar os dados
                while ($dados = mysqli_fetch_assoc($rs)) {
                    $id = $dados['idImpressora'];
                ?>
                    <!-- Se alguma célula tiver com dados muito grande, adicionar no td -> style="overflow:hidden; white-space: nowrap;"
                                                                        e adicionar na div table -> style="table-layout: fixed;"  -->
                    <tr>
                        <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= strip_tags($dados["nomeImpressora"]) ?></td>
                        <td class="text-nowrap" style="overflow:hidden; white-space: nowrap;"><?= strip_tags($dados["cursoImpressora"]) ?></td>
                        <td><?= $dados["semestreImpressora"] ?>º</td>
                        <td><?= $dados["dataImpressora"] ?></td>
                        <td><?= $dados["deHoraImpressora"] ?> - <?= $dados["ateHoraImpressora"] ?></td>
                        <td><?= $dados["qualImpressora"] ?></td>
                        <td class="text-center"><a href="index.php?menuop=impressora-edit-step1&idImpressora=<?= $dados["idImpressora"] ?>"><?php if ($dados['idUsuario'] == $_SESSION['usuario_id'] || $_SESSION['administrador'] == 1) {
                            echo '<i class="bi bi-pencil-square" style="color:#78126b ;"></i>';
                        } ?></a></td>
                        <td class="text-center"><a href="index.php?menuop=impressora-confirmar-excluir&idImpressora=<?= $dados["idImpressora"] ?>"><?php if ($dados['idUsuario'] == $_SESSION['usuario_id'] || $_SESSION['administrador'] == 1) {
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
        echo '<li class="page-item"><a class="page-link" href="?menuop=impressora&pagina=1"><i class="bx bx-chevrons-left" ></i></a></li>';

        // Método de paginação
        if ($pagina > 6) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=impressora&pagina=<?php echo $pagina - 1 ?>" aria-label="Anterior"> <i class='bx bx-chevron-left'></i> </a></li>
        <?php
        }

        // Loop para numeração das páginas
        for ($i = 1; $i <= $totalPaginas; $i++) {

            if ($i >= ($pagina - 5) && $i <= ($pagina + 5)) {
                if ($i == $pagina) {
                    echo "<li class='page-item active page-item.active'><span class='page-link'>$i</span></li>";
                } else {
                    echo "<li class='page-item'> <a class='page-link' href=\"?menuop=impressora&pagina=$i \">$i</a></li> ";
                }
            }
        }

        // Método de paginação
        if ($pagina < ($totalPaginas - 5)) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=impressora&pagina=<?php echo $pagina + 1 ?>" aria-label="Proximo"> <i class='bx bx-chevron-right'></i> </a></li>
        <?php
        }

        // Última página
        echo "<li class='page-item'><a class='page-link' href=\"?menuop=impressora&pagina=$totalPaginas\"><i class='bx bx-chevrons-right' ></i></a></li>";

        ?>
    </ul>
</div>