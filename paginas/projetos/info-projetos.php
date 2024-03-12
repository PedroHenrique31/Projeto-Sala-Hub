<?php

if (!isset($_SESSION)) {
    session_start();
}

// Checa se "&idProjetos=X" foi apagado da URL
if (!isset($_GET['idProjetos'])) {
    header('Location: index.php?menuop=projetos');
    exit();
}

// adquire o ID do Projeto
$idProjetos = $_GET['idProjetos'];


// Select para pegar os dados do ID
$sql = "SELECT * FROM tbprojetos WHERE idProjetos = {$idProjetos}";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
if (mysqli_num_rows($rs) == 0 || $dados['visivelProjetos'] != 0) {
    header("Location: index.php?menuop=projetos");
    exit();
} else {
    $titulo = $dados['nomeProjetos'];
    $autor = $dados['autoresProjetos'];
    $curso = $dados['cursoProjetos'];
    $semestre = $dados['semestreProjetos'];
    $orientador = $dados['orientadorProjetos'];
    $resumo = $dados['resumoProjetos'];
    $usuarioId = $dados['usuarioIdProjetos'];
}

?>


<div class="container">

    <?php

    // Select para pegar o Arquivo
    $sqlFile = "SELECT * FROM tbarquivos WHERE idSeuProjeto = {$idProjetos}";
    $rsFile = mysqli_query($conexao, $sqlFile) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
    $dadosFile = mysqli_fetch_assoc($rsFile);

    if (isset($dadosFile['nomeArquivo'])) {
        $nomeArquivo = $dadosFile['nomeArquivo'];
    } else {
        $nomeArquivo = NULL;
    }

    ?>

    <header class="text-center mt-3 mb-4 me-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Projetos</span>
        </div>
    </header>
    
    <div class="row mt-3" style="min-height: 400px;">
        <div class="col-6 text-center container-fluid">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <?php
                    // Consulta sql para pegar as imagens
                    $sqlImg = "SELECT nomeImagem FROM tbimagens WHERE idSeuProjeto = $idProjetos";
                    $rsImg = mysqli_query($conexao, $sqlImg) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                    // Loop para armazenar os dados em um array
                    $rsArray = array();
                    while ($dadosImg = mysqli_fetch_assoc($rsImg)) {
                        array_push($rsArray, $dadosImg['nomeImagem']);
                    }
                    ?>

                    <?php
                    // Código PHP para apresentar os botões
                    if (count($rsArray)) { ?>
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <?php }
                    // Loop para apresentar os botões
                    for ($i = 1; $i < count($rsArray); $i++) { ?>
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $i ?>" aria-label="<?= 'Slide ' . $i ?>"></button>
                    <?php } ?>

                </div>
                <div class="carousel-inner">
                    <!-- Primeiro item -->
                    <div class="carousel-item active">
                        <?php
                        if (count($rsArray) > 0) { ?>
                            <img src="<?= 'uploads/img/' . $idProjetos . '/' . $rsArray[0] ?>" class="d-block w-100 img-fluid project-img" alt="imagemProjeto">
                        <?php } else { ?>
                            <img src="img/sche.jpg" class="d-block w-100 img-fluid project-img" alt="imagemProjeto">
                        <?php } ?>
                    </div>
                    <?php
                    // Loop para apresentar as imagens secundárias
                    for ($i = 1; $i <= (count($rsArray) - 1); $i++) { ?>
                        <div class="carousel-item">
                            <img src="<?= 'uploads/img/' . $idProjetos . '/' . $rsArray[$i] ?>" class="d-block w-100 img-fluid project-img" alt="imagemProjeto">
                        </div>
                    <?php }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-6 d-flex flex-column g-0" style="height: auto;">
            <div class="fs-2 fw-bold">
                <?php echo "$titulo" ?>
            </div>
            <div class="fs-5"><?php echo "$autor" ?></div>
            <div class="d-flex align-items-end" style="height: 100%;">
                <div class="row flex-fill">
                    <div class="fs-6"><?php echo "$curso" ?> - <?php echo "$semestre" ?>º</div>
                    <div class="fs-6">Orientador: <?php echo "$orientador" ?></div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-3">
        <div class="fw-bold fs-5">Resumo</div>
        <div class="about">
            <?php // echo "$resumo" 
            ?>
            <?php echo htmlentities($resumo) ?>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <div>
            <ul class="list-group list-group-horizontal">
                <?php
                // Checa se o PDF existe
                if (file_exists('uploads/arquivos/' . $idProjetos . '/' . $nomeArquivo)) { ?>
                    <li class="list-group-item"><a href="<?= 'uploads/arquivos/' . $idProjetos . '/' . $nomeArquivo ?>" class="text-decoration-none" target="_blank">Abrir PDF</a></li>
                    <li class="list-group-item"><a href="<?= 'uploads/arquivos/' . $idProjetos . '/' . $nomeArquivo ?>" class="text-decoration-none" download>Baixar PDF</a></li>
                <?php } else { ?>
                    <li class="list-group-item">Sem PDF</li>
                <?php } ?>
            </ul>
        </div>

    </div>

    <?php if (isset($_SESSION['usuario_id'])) {
        if ($usuarioId == $_SESSION['usuario_id'] || $_SESSION['administrador'] == 1) { ?>
            <div class="d-flex flex-row mt-2">
                <div>
                    <a href="index.php?menuop=formulario-editar-projetos&idProjetos=<?= $idProjetos ?>" class="link-secondary">Editar</a>
                </div>
                <div class="ms-2">
                    <a href="index.php?menuop=confirmar-excluir-projetos&idProjetos=<?= $idProjetos ?>" class="link-secondary">Excluir</a>
                </div>

            </div>
    <?php }
    } ?>
</div>