<?php
include('verifica_login.php');
?>

<?php

if($_SESSION['administrador'] != 1){
    header('Location: index.php?menuop=usuarios');
    exit();
}

?>

<div class="container">
    <header class="text-center mt-3 mb-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Monitores</span>
        </div>
    </header>

    <!-- Barra de pesquisa --->
    <div class="d-flex justify-content-between">
        <div>
            <form action="index.php?menuop=usuario" method="post">
                <div class="input-group">
                    <div>
                        <input class="form-control" type="text" name="txt_pesquisa" placeholder="Pesquisar...">
                    </div>
                    <button class="btn btn-outline-ceub btn-sm" type="submit"><i class="bi bi-search"></i> Pesquisar...</button>
                </div>
            </form>
        </div>
        <div class="d-flex flex-row">
            <!-- Link para cadastrar usuário --->
            <?php if ($_SESSION['administrador'] == 1) { ?>
                <form action="index.php?menuop=step1-monitores" method="post">
                    <input class="btn btn-light" type="submit" value="Cadastrar monitor">
                    <input type="hidden" name="nomeMonitor" value="">
                    <input type="hidden" name="telefoneMonitor" value="">
                    <input type="hidden" name="deHoraMonitor" value="">
                    <input type="hidden" name="ateHoraMonitor" value="">
            </form>
            <?php } ?>
        </div>
    </div>


    <!-- Tópicos da tabela --->
    <div class="tabela table-responsive mt-3">
        <table class="table table-striped shadow-sm table-bordered">
            <thead>
                <tr>
                    <th><i class="bi bi-person-fill"> </i>Nome</th>
                    <th>Telefone</th>
                    <th>Horário</th>
                    <th class="text-center">Editar</th>
                    <th class="text-center">Excluir</th>
                </tr>
            </thead>

            <tbody>
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

                // Quantidade de items por página
                $quantidade = 10;
                // Variável qual página ir
                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                // Variável para guardar o inicio da listagem
                $inicio = ($quantidade * $pagina) - $quantidade;

                // Variável de pesquisa para pesquisar na tabela
                $txt_pesquisa = (isset($_POST["txt_pesquisa"])) ? $_POST["txt_pesquisa"] : "";

                // Método SQL para mostrar a tabela
                $sql = "SELECT idMonitor, nomeMonitor, telefoneMonitor, deHoraMonitor, ateHoraMonitor FROM tbmonitor
                WHERE nomeMonitor LIKE '%{$txt_pesquisa}%' or telefoneMonitor LIKE '%{$txt_pesquisa}%' ORDER BY idMonitor ASC
                LIMIT {$inicio}, {$quantidade}";

                // Variável para executar a consulta
                $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                // Loop para mostrar os dados
                while ($dados = mysqli_fetch_assoc($rs)) {
                    $id = $dados['idMonitor'];

                    // Formatação do telefone
                    $n = $dados['telefoneMonitor']; // número que o usuário digitou
                    $str = $n; // Exemplo para telefone
                    // echo format_string('(##)#####-####', $str);


                ?>
                    <tr>
                        <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= strip_tags($dados["nomeMonitor"]) ?></td>
                        <td><?php echo format_string('(##) #####-####', $str); ?></td>
                        <td><?php echo substr($dados["deHoraMonitor"], 0, -3); ?> - <?php echo substr($dados["ateHoraMonitor"], 0, -3); ?></td>
                        <td class="text-center"><a href="index.php?menuop=edit1-monitores&idMonitor=<?= $dados["idMonitor"] ?>"><i class="bi bi-pencil-square" style="color:#78126b ;"></i></a></td>
                        <td class="text-center"><a href="index.php?menuop=confirmar-excluir-monitores&idMonitor=<?= $dados["idMonitor"] ?>"><i class="bi bi-trash3" style="color:#78126b ;"></i></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <ul class="pagination justify-content-center">

        <?php
        $sqlTotal = "SELECT idMonitor FROM tbmonitor";
        // Query results
        $qrTotal = mysqli_query($conexao, $sqlTotal) or die("Erro na query results. " . mysqli_error($conexao));
        $numTotal = mysqli_num_rows($qrTotal);
        $totalPaginas = ceil($numTotal / $quantidade);

        // Mostra o número de registros ao lado da paginação
        // echo "<li class='page-item'><span class='page-link'>Total de Registros: ". $numTotal . "</span></li>";

        // Primeira página
        echo '<li class="page-item"><a class="page-link" href="?menuop=monitores&pagina=1"><i class="bx bx-chevrons-left" ></i></a></li>';

        // Método de paginação
        if ($pagina > 6) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=monitores&pagina=<?php echo $pagina - 1 ?>" aria-label="Anterior"> <i class='bx bx-chevron-left'></i> </a></li>
        <?php
        }

        // Loop para numeração das páginas
        for ($i = 1; $i <= $totalPaginas; $i++) {

            if ($i >= ($pagina - 5) && $i <= ($pagina + 5)) {
                if ($i == $pagina) {
                    echo "<li class='page-item active page-item.active'><span class='page-link'>$i</span></li>";
                } else {
                    echo "<li class='page-item'> <a class='page-link' href=\"?menuop=monitores&pagina=$i \">$i</a></li> ";
                }
            }
        }

        // Método de paginação
        if ($pagina < ($totalPaginas - 5)) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=monitores&pagina=<?php echo $pagina + 1 ?>" aria-label="Proximo"> <i class='bx bx-chevron-right'></i> </a></li>
        <?php
        }

        // Última página
        echo "<li class='page-item'><a class='page-link' href=\"?menuop=monitores&pagina=$totalPaginas\"><i class='bx bx-chevrons-right' ></i></a></li>";

        ?>
    </ul>
</div>