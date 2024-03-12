<?php
include('verifica_login.php');
?>

<div class="container">
    <header class="text-center mt-3 mb-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Usuários</span>
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
            <?php if($_SESSION['administrador'] == 1){ ?>
                <a href="index.php?menuop=monitores" class="btn btn-light me-2" role="button">Gerenciar monitores</a>
            <?php } ?>
            <!-- Link para cadastrar usuário --->
            <?php if ($_SESSION['administrador'] == 1) {
                echo ('<form action="index.php?menuop=cad-usuario" method="post">
        <input class="btn btn-light" type="submit" value="Novo usuário">
        <input type="hidden" name="usuario" value="">
        <input type="hidden" name="nome" value="">
        </form>');
            }
            ?>
        </div>


    </div>


    <!-- Tópicos da tabela --->
    <div class="tabela table-responsive mt-3">
        <table class="table table-striped shadow-sm table-bordered">
            <thead>
                <tr>
                    <th><i class="bi bi-person-fill"> </i>Nome</th>
                    <th>Login</th>
                    <th>Perfil</th>
                    <th>Último acesso</th>
                    <th class="text-center">Editar</th>
                    <?php if ($_SESSION['administrador'] == 1) {
                        echo ('<th class="text-center">Excluir</th>');
                    } ?>

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
                $sql = "SELECT usuario_id, nome AS nome, usuario, DATE_FORMAT(dataLogin, '%d/%m/%Y %T') AS dataLogin, administrador FROM usuario
                WHERE usuario_id = '{$txt_pesquisa}' or nome LIKE '%{$txt_pesquisa}%' ORDER BY usuario_id ASC
                LIMIT {$inicio}, {$quantidade}";

                // Variável para executar a consulta
                $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                // Loop para mostrar os dados
                while ($dados = mysqli_fetch_assoc($rs)) {
                    $id = $dados['usuario_id'];
                ?>
                    <tr>
                        <td class="text-nowrap bi bi-person-fill" style="color:#78126b"> <?= strip_tags($dados["nome"]) ?></td>
                        <td class="text-nowrap"><?= strip_tags($dados["usuario"]) ?></td>
                        <td class="text-nowrap"><?php if ($dados["administrador"] == 1) {
                                                    echo 'Administrador';
                                                } else {
                                                    echo 'Usuário';
                                                } ?></td>
                        <td class="text-nowrap"><?= $dados["dataLogin"] ?></td>
                        <td class="text-center"><a href="index.php?menuop=editar-usuario&usuario_id=<?= $dados["usuario_id"] ?>"><?php if ($dados['usuario_id'] == $_SESSION['usuario_id'] || $_SESSION['administrador'] == 1) {
                                                                                                                                        echo '<i class="bi bi-pencil-square" style="color:#78126b ;"></i>';
                                                                                                                                    } ?></a></td>
                        <?php if ($_SESSION['administrador'] == 1) {
                            echo ('<td class="text-center">');
                        } ?><a href="index.php?menuop=excluir-usuario&usuario_id=<?= $dados["usuario_id"] ?>"><?php if ($_SESSION['administrador'] == 1) {
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
        $sqlTotal = "SELECT usuario_id FROM usuario";
        // Query results
        $qrTotal = mysqli_query($conexao, $sqlTotal) or die("Erro na query results. " . mysqli_error($conexao));
        $numTotal = mysqli_num_rows($qrTotal);
        $totalPaginas = ceil($numTotal / $quantidade);

        // Mostra o número de registros ao lado da paginação
        // echo "<li class='page-item'><span class='page-link'>Total de Registros: ". $numTotal . "</span></li>";

        // Primeira página
        echo '<li class="page-item"><a class="page-link" href="?menuop=usuario&pagina=1"><i class="bx bx-chevrons-left" ></i></a></li>';

        // Método de paginação
        if ($pagina > 6) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=usuario&pagina=<?php echo $pagina - 1 ?>" aria-label="Anterior"> <i class='bx bx-chevron-left'></i> </a></li>
        <?php
        }

        // Loop para numeração das páginas
        for ($i = 1; $i <= $totalPaginas; $i++) {

            if ($i >= ($pagina - 5) && $i <= ($pagina + 5)) {
                if ($i == $pagina) {
                    echo "<li class='page-item active page-item.active'><span class='page-link'>$i</span></li>";
                } else {
                    echo "<li class='page-item'> <a class='page-link' href=\"?menuop=usuario&pagina=$i \">$i</a></li> ";
                }
            }
        }

        // Método de paginação
        if ($pagina < ($totalPaginas - 5)) {
        ?>
            <li class="page-item"><a class="page-link" href="?menuop=usuario&pagina=<?php echo $pagina + 1 ?>" aria-label="Proximo"> <i class='bx bx-chevron-right'></i> </a></li>
        <?php
        }

        // Última página
        echo "<li class='page-item'><a class='page-link' href=\"?menuop=usuario&pagina=$totalPaginas\"><i class='bx bx-chevrons-right' ></i></a></li>";

        ?>
    </ul>
</div>