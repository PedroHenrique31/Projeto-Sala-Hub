<?php
include('verifica_login.php');
?>

<?php

if (!isset($_SESSION['administrador'])) {
    header('Location: index.php?menuop=projetos');
    exit();
}

if ($_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=projetos');
    exit();
}

?>



<div class="container">
    <header class="fs-3 text-center mt-3">
        Restaurar Projeto
    </header>

    <!-- Barra de pesquisa --->
    <div class="d-flex justify-content-between">
        <form action="index.php?menuop=escolher-restaurar-projetos" method="post">
            <div class="input-group">
                <div>
                    <input class="form-control" type="text" name="txt_pesquisa" placeholder="Pesquisar...">
                </div>
                <button class="btn btn-outline-ceub btn-sm" type="submit"><i class="bi bi-search"></i> Pesquisar...</button>
            </div>
        </form>
    </div>

    <!-- Tópicos da tabela --->
    <div class="table-responsive mt-3">
        <table class="table border shadow-sm">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Capa</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Curso</th>
                    <th>Orientador</th>
                    <th class="text-center">Restaurar</th>
                    <th class="text-center">Deletar projeto</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">
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
                $sql = "SELECT idProjetos, nomeProjetos, autoresProjetos, cursoProjetos, semestreProjetos, orientadorProjetos FROM tbprojetos 
                WHERE(idProjetos = '{$txt_pesquisa}' and visivelProjetos = 1) or (nomeProjetos LIKE '%{$txt_pesquisa}%' and visivelProjetos = 1) 
                or (autoresProjetos LIKE '%{$txt_pesquisa}%' and visivelProjetos = 1) or (cursoProjetos LIKE '%{$txt_pesquisa}%' and visivelProjetos = 1) 
                or (orientadorProjetos LIKE '%{$txt_pesquisa}%' and visivelProjetos = 1) ORDER BY idProjetos ASC 
                LIMIT {$inicio}, {$quantidade}";

                // Variável para executar a consulta
                $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                // Loop para mostrar os dados
                while ($dados = mysqli_fetch_assoc($rs)) {
                    $id = $dados['idProjetos'];

                    // PEGA IMAGEM DO PROJETO
                    $sqlImg = "SELECT * FROM tbimagens WHERE idSeuProjeto = '$id' LIMIT 1";
                    $rsImg = mysqli_query($conexao, $sqlImg) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                    $temImagem = 0;

                    if ($dadosImg = mysqli_fetch_assoc($rsImg)) {
                        $firstImage = $dadosImg['nomeImagem'];
                        $temImagem = 1;?>
                    <?php } else {
                        $temImagem = 0;?>
                    <?php } ?>
                    <!-- Se alguma célula tiver com dados muito grande, adicionar no td -> style="overflow:hidden; white-space: nowrap;"
                                                                        e adicionar na div table -> style="table-layout: fixed;"  -->
                    <tr class="align-middle">
                        <td class="text-center"><h5><?= $dados['idProjetos']?></h5></td>
                        <td class="text-center"><?php if($temImagem){?><img src="<?= 'uploads/img/' . $id . '/' . $firstImage ?>" class="restore-project-img" alt="">
                            <?php }else{?><img src="img/woman.jpg" class="restore-project-img" alt="imagemDoProjeto"><?php }?></td>
                        <td class="text-nowrap" style="overflow:hidden; white-space: nowrap;"><span class="fw-bold"><?= $dados["nomeProjetos"] ?></span></td>
                        <td><?= $dados["autoresProjetos"] ?></td>
                        <td><?= $dados["cursoProjetos"] ?> - <?= $dados["semestreProjetos"] ?>º</td>
                        <td><?= $dados["orientadorProjetos"] ?></td>
                        <td class="text-center"><a href="index.php?menuop=restaurar-projetos&idProjetos=<?= $dados['idProjetos']?>"><i class="bx bx-sync bx-md" style="color:#78126b ;"></i></a></td>
                        <td class="text-center"><a href="index.php?menuop=confirmar-deletar-projeto&idProjetos=<?= $dados['idProjetos']?>"><i class="bi bi-trash3" style="color:#78126b ;"></i></a></td>
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